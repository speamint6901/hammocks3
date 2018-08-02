<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\BaseApiController;

class WebScrapingController extends BaseApiController
{

    // 指定のurlに対して画像だけ取り出す
    public function getImageList(Request $request) {
        $parse_url = parse_url($request->input('url'));
        $crawler = \Goutte::request('GET', $request->input('url'));
        $url = $crawler->filter('img')->each(function($tag) {
            return $tag->attr('src');
        });

        $result_url = [];
        foreach ($url as $u) {
            $result_url[] = $this->convertPathToUrl($u, $parse_url);
        }

        return new JsonResponse($result_url);
    }

    public function convertPathToUrl($target_path, $component) {

        $directory = preg_replace('!/[^/]*$!', '/', $component["path"]);

        $uri = null;

        switch (true) {
            case preg_match("/^http/", $target_path):
                $uri = $target_path;
                break;
            case preg_match("/^\/\/.+/", $target_path):
                $uri =  $component["scheme"].":".$target_path;
                break;
            case preg_match("/^\/[^\/].+/", $target_path):
                $uri =  $component["scheme"]."://".$component["host"].$target_path;
                break;
            case preg_match("/^\.\/(.+)/", $target_path,$maches):
                $uri =  $component["scheme"]."://".$component["host"].$directory.$maches[1];
                break;
            case preg_match("/^([^\.\/]+)(.*)/", $target_path,$maches):
                $uri =  $component["scheme"]."://".$component["host"].$directory.$maches[1].$maches[2];
                break;
            case preg_match("/^\.\.\/.+/", $target_path):
                preg_match_all("!\.\./!", $target_path, $matches);
                $nest =  count($matches[0]);

                $dir = preg_replace('!/[^/]*$!', '/', $component["path"])."\n";
                $dir_array = explode("/",$dir);
                array_shift($dir_array);
                array_pop($dir_array);
                $dir_count = count($dir_array);
                $count = $dir_count - $nest;
                $pathto="";
                $i = 0;
                while ( $i < $count) {
                    $pathto .= "/".$dir_array[$i];
                    $i++;
                }
                $file = str_replace("../","",$target_path);
                $uri =  $component["scheme"]."://".$component["host"].$pathto."/".$file;
                break;
        }

        return $uri;

    }

}
