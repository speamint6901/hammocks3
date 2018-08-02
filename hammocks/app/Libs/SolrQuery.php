<?php

namespace App\Libs;
/**
* solr input
* ドキュメントの全文検索
*/

class SolrQuery extends SolrBase {

    /**
    * \SolrClient
    */
    public $doc;

    public $query_response;

    /**
    * コンストラクタ
    *
    * @params string $doc_name コアドキュメント名
    * @return \App\Libs\SolrBase
    */
    public function __construct(string $doc_name) {
        parent::__construct($doc_name);
        $this->doc = new \SolrQuery();
        return $this;
    }

    /**
    * クエリをセットする
    *
    * @params string $field_name フィールド名
    * @return \App\Libs\SolrQuery
    */
    public function setQuery(string $query_string) {
        $this->doc->setQuery($query_string);
        return $this;
    }

    /**
    * レスポンス時に含むフィールド指定
    *
    * @params string $field_name フィールド名
    * @return \App\Libs\SolrQuery
    */
    public function addField(string $field_name) {
        $this->doc->addField($field_name);
        return $this;
    }

    /**
    * クエリをコールする
    *
    * @return \SolrQueryResponse
    */
    public function query() {
        if (is_null($this->doc)) { 
            throw new SolrDocumentErrorException("query not found please setQuery called file:" . __FILE__ . " line:" . __LINE__);
        }
        $this->query_response = $this->client->query($this->doc);
        return $this;
    }

    /**
    * レスポンスを取得する
    *
    * @return \App\Libs\SolrResponse
    */
    public function getResponse() {
        return $this->query_response->getResponse();
    }

    /**
    * レスポンスのoffsetをセットする
    *
    * @params $start int オフセット値
    * @return \App\Libs\SolrQuery
    */
    public function setOffset($start) {
        $this->doc->setStart($start);
        return $this;
    }

    public function setStart($num) {
        $this->doc->setStart($num);
        return $this;
    }

    /**
    * レスポンスのlimit値をセットする
    *
    * @params $row int リミット値
    * @return \App\Libs\SolrQuery
    */
    public function setRows($start) {
        $this->doc->setRows($start);
        return $this;
    }

}
