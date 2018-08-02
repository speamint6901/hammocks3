<?php

namespace App\Libs;
/**
* solr input
* ドキュメントの保存、index作成
*/

class SolrInput extends SolrBase {

    public $doc;

    public function __construct(string $doc_name) {
        parent::__construct($doc_name);
        $this->doc = new \SolrInputDocument();
        return $this;
    }

    /**
    * solrドキュメントに保存する
    *
    * @params array $params ["field名" => "value名"]
    */
    public function setDocument(Array $params) {
        foreach ($params as $key => $param) {
            $this->doc->addField($key, $param);
        }
        $this->client->addDocument($this->doc);
        $response = $this->client->commit();
        if (!$response->success()) {
            throw new SolrDocumentErrorException("solr document save error file:" . __FILE__ . " line:" . __LINE__);
        }
    }

    /**
    * 複数のレコードをsolrドキュメントに保存する
    *
    * @params array [0 => ["field名" => "value"]]
    */
    public function setDocuments(array $params) {
        foreach ($params as $param) {
            $this->setDocument($param);
        }
    }
}
