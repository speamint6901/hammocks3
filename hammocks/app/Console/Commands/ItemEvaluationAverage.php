<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item\Evaluation as ItemEvaluation;

class ItemEvaluationAverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'item_evaluation:average';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * アイテム評価（サンダー）の平均値を出して、更新する
     *
     * @return mixed
     */
    public function handle()
    {
        // １００件ずつ処理する
        ItemEvaluation::with('item_evaluation_users')->chunk(100, function($item_evaluations) {
            // パブリックアイテムの５段階評価を一件ずつ処理する
            foreach ($item_evaluations as $item_evaluation) {
                // ユーザー毎の評価件数を取得
                $count = $item_evaluation->item_evaluation_users->count();
                // 評価が一件でも付いていたら処理
                if ($count > 0) {
                    $average = $this->execItemEvaluationAverage($item_evaluation, $count); 
                    $item_evaluation->average = $average;
                    $item_evaluation->save();
                }
            }
        });
    }

    /**
    * サンダーの平均値を一件ずつ出して返す(小数点第一まで）
    *
    * @params ¢item_evaluation  App\Modesl\Item\Evaluation
    * @return float
    */
    public function execItemEvaluationAverage($item_evaluation, $count) {
        if ($count > 1) {
            // 2件以上なら平均値を出して返す
            $evaluation_sum = $item_evaluation->item_evaluation_users->sum("evaluation_num");
            return round($evaluation_sum / $count, 1);
        } else {
            // 一件のみなら、そのまま返す
            return $item_evaluation->item_evaluation_users->evaluation_num;
        }
    }
}
