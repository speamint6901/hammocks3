{{-- resources/views/emails/registration_confirmation.blade.php --}}


@extends('emails.template.master')

@section('content')
<table>
 <tr>
  <td>

   <h2>hammocks ユーザー登録確認</h2>

   <p>
    ようこそ、<span class="important">{{ $user['name'] }}</span> さん
   </p>
   <br>
   <p>
    ユーザー登録を完了する為に<br>
    下の写真をクリックしてhammocksに"camp in"してください。
   </p>


  </td>
 </tr>
</table>
@endsection


@section('addcontents')
<table class="common_content-wrap" bgcolor="#FFFFFF">
 <tr align="center">
  <a href="{{ url('auth/confirm', [$token]) }}">
   <img src="{{ asset('images/mail/campin.jpg') }}" alt="hammocks CAMP IN">
  </a>
 </tr>
</table>
@endsection
