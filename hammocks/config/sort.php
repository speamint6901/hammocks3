<?php

return [
    "master_item" => [
        "select_box" => [
            "1" => "登録順",
            "2" => "want多い順",
            "3" => "have多い順",
            "4" => "記事数多い順",
            "5" => "評価高い順",
            "6" => "評価低い順",
        ],
        "rep" => [
            "1" => "created_at:desc",
            "2" => "want_count:desc",
            "3" => "have_count:desc",
            "4" => "article_count:desc",
            "5" => "average:desc",
            "6" => "average:asc",           
        ],
    ],
    "sale_item" => [
        "select_box" => [
            "1" => "登録順",
            "2" => "値段が安い順",
            "3" => "値段が高い順",
        ],
        "rep" => [
            "1" => "created_at:desc",
            "2" => "price:asc",
            "3" => "price:desc",
        ],
    ], 
    "article" => [
        "select_box" => [
            "1" => "登録順",
            "2" => "pickが多い順",
        ],
        "rep" => [
            "1" => "created_at:desc",
            "2" => "count:desc",
        ],
    ],
];
