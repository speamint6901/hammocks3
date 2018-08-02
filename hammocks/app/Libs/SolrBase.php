<?php

namespace App\Libs;
/**
* solr base
* solrの接続情報などを管理する
*/

class SolrBase {

    /**
    * documentのパス
    */
    protected $doc_path = [
        "items" => "solr/items",
        "article" => "solr/article",
        "store_items" => "solr/store_items",
    ];

    /**
    * \SolrClient
    */
    public $client;

    /**
    * インスタンス取得
    *
    * @params string $doc_name コアドキュメント名
    * @return static class
    */
    public static function forge(string $doc_name) {
        return new static($doc_name); 
    }

    /**
    * コンストラクタ
    *
    * @params string $doc_name コアドキュメント名
    * @return \App\Libs\SolrBase
    */
    public function __construct(string $doc_name) {
        $options = \Config::get('solr.options');
        $options["path"] = $this->getDocPath($doc_name);
        $this->client =  new \SolrClient($options);
        return $this;
    }

    /**
    * コアドキュメントのパスを取得する
    *
    * @params $doc_name string コアドキュメント名
    * @return string コアドキュメントのパス
    */
    public function getDocPath($doc_name) {
        return $this->doc_path[$doc_name];
    }
}
