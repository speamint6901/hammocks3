<?php

namespace App\Http\Controllers;


class CommercialController extends Controller
{

    // 特定商取引法ページ
    public function showIndex() {
        return \View::make('guide.commercial_law', $this->data);
    }
}
