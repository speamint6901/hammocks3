<?php namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use App\Models\SnsUsers;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $redirectAfterLogout = 'auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getLogout']]);
        // リダイレクト先を動的に変更
        $url_referer = $request->session()->get("url_referer");
        if ( ! is_null($url_referer)) {
            $this->redirectTo = $url_referer;
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:32',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:20|confirmed',
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
                    ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('auth.login', $this->data);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        $sns_user = session("sns_user", null);
        if ( ! is_null($sns_user)) {
            $this->data["user_name"] = $sns_user->name;
        }

        return view('auth.register', $this->data);
    }

    public function postRegister(Request $request) {

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        // sns連携時
        $sns_user = $request->session()->get("sns_user", null);
        // トランザクションの開始
        \DB::beginTransaction();

        try {

            $this->create($request->all(), \Config::get('app.key'), $sns_user);
            \Session::flash('flash_message', 'ユーザー登録確認メールを送りました。');
            \DB::commit();
        } catch (Exception $e) {
            // ロック解除
            \DB::rollBack();
            throw $e;
        }

        return redirect('auth/login');
     }

    /**
    * postLoginカスタム
    * 既存の機能にメール認証チェックをかける
    *
    * @params $request  \Request
    * @return mixed
    */
    public function postLogin(Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        $user = User::where('email', '=', $credentials['email'])->first();
        if ($user) {
            if(! $user->isConfirmed()) {
                \Session::flash('flash_message', 'ユーザー登録確認メールに従って、ユーザーを有効化してください。');
                return redirect()->back()->withInput($request->only('email'));
            }
        }

        if (\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $app_key, $sns_user = null)
    {
        // ユーザー登録
        // トランザクションの開始
        \DB::beginTransaction();
        try {

            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->makeConfirmationToken($app_key);
            $user->confirmation_sent_at = Carbon::now();
            $user->save();
            // sns連携あれば
            if ( ! is_null($sns_user)) {
                if (isset($sns_user->avatar_original)) {
                    $user->avater_img_url = $sns_user->avatar_original;
                    $user->save();
                }
                $this->saveSnsUsers($sns_user, $user->id);
            }

            $this->otherUserInfoSave($user);

            \DB::commit();
            return $user;

        } catch (Exception $e) {
            \DB::rollBack();           
            throw $e;
        }

    }

    // sns情報登録
    public function saveSnsUsers($sns_session_user, $users_id) {
        $sns_user = SnsUsers::findSnsUserBySocialIdAndType($sns_session_user->id, $sns_session_user->sns_type);
        if ( is_null($sns_user)) {
            $sns_user = new SnsUsers();
            $sns_user->users_id = $users_id;
            $sns_user->social_id = $sns_session_user->id;
            $sns_user->type = $sns_session_user->sns_type;
        }
        $sns_user->status = 1;
        $sns_user->save();
    }

    // 他の必要テーブルでレコード作成
    // ユーザーIDのみ
    protected function otherUserInfoSave($user) {
         // プロフィール登録
        $profile = new \App\Models\User\Profile;
        $profile->users_id = $user->id;
        $profile->save();

        // user_info_count登録
        $user_info_count = new \App\Models\User\InfoCount;
        $user_info_count->users_id = $user->id;
        $user_info_count->save();

        // user_secret_profile登録
        $user_secret_profile = new \App\Models\User\SecretProfile;
        $user_secret_profile->users_id = $user->id;
        $user_secret_profile->is_sms_auth = 0;
        $user_secret_profile->is_certificate_auth = 0;
        $user_secret_profile->save();
        
        // todo mail送信
        $this->sendConfirmMail($user);
    }

    // facebook
    public function facebookLogin() {
        return Socialite::driver('facebook')->redirect();
    }

    // twitter
    public function twitterLogin() {
        return Socialite::driver('twitter')->redirect();
    }

    // facebook
    public function facebookRegister() {
        return Socialite::driver('facebook')->with(["callback_h_type" => "register"])->redirect();
    }

    // twitter
    public function twitterRegister() {
        return Socialite::driver('twitter')->with(["callback_h_type" => "register"])->redirect();
    }

    // facebookログイン
    public function facebookDoLogin(Request $request) {

        try {
            /** @var \Laravel\Socialite\Contracts\User $user */
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/login');
        }

        $authUser = $this->findOrCreateUserFacebook($user, $request);
        if ( is_null($authUser)) {
            return redirect("auth/register");
        }
        \Auth::login($authUser, true);    

        return redirect($this->redirectTo);
    }

    // facebookログイン
    public function twitterDoLogin(Request $request) {

        try {
            /** @var \Laravel\Socialite\Contracts\User $user */
            $user = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect('auth/login');
        }

        $authUser = $this->findOrCreateUserTwitter($user, $request);
        if ( is_null($authUser)) {
            return redirect("auth/register");
        }
        \Auth::login($authUser, true);    

        return redirect($this->redirectTo);
    }

    /**
     * facebookユーザーが見つからなければ、登録
     *
     * @param $facebook_user
     * @return User
     */
    private function findOrCreateUserFacebook($facebook_user, $request)
    {
        $authUser = SnsUsers::findSnsUserBySocialIdAndType($facebook_user->id, SnsUsers::SNS_TYPE_FACEBOOK, 1);

        if ($authUser){
            $user = User::where("id", $authUser->users_id)->first();
            return $user;
        } else {
            // 新規
            $facebook_user->sns_type = SnsUsers::SNS_TYPE_FACEBOOK;
            $request->session()->put("sns_user", $facebook_user);
            return null;
        }
    }

    /**
     * facebookユーザーが見つからなければ、登録
     *
     * @param $facebook_user
     * @return User
     */
    private function findOrCreateUserTwitter($twitter_user, $request)
    {
        $authUser = SnsUsers::findSnsUserBySocialIdAndType($twitter_user->id, SnsUsers::SNS_TYPE_TWITTER, 1);

        if ($authUser){
            $user = User::where("id", $authUser->users_id)->first();
            return $user;
        } else {
            // 新規
            $twitter_user->sns_type = SnsUsers::SNS_TYPE_TWITTER;
            $request->session()->put("sns_user", $twitter_user);
            return null;
        }
    }

    public function getConfirm($token) {
        $user = User::where('confirmation_token', '=', $token)->first();
        if ( ! $user) {
            \Session::flash('flash_message', '無効なトークンです。');
            return redirect('auth/login');
        }

        $user->confirm();
        $user->save();

        \Session::flash('flash_message', 'ユーザー登録が完了しました。ログインしてください。');
        return redirect('auth/login');
    }

    private function sendConfirmMail(User $user) {
        Mail::send(
            'emails.registration_confirmation',
            ['user' => $user, 'token' => $user->confirmation_token],
            function($message) use ($user) {
                $message->to($user->email, $user->name)->subject('ユーザー登録確認');
            }
        );
    }
}
