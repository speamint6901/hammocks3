<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Service\ItemControllerLogic as Logic;
 
class ItemController extends Controller
{

    // パラメータに検索ワードがあれば、idに変換してセットする
    protected static function setIdsSearchWordParams($params, $type) {
        $params["ids"] = Logic::getItemsIdsBySolrQuery($params, $type);
        return $params;
    }
    
}
