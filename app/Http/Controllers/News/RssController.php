<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\RssModel;
use App\Helpers\Feed;
use Illuminate\Http\Request;

class RssController extends Controller
{
    private $pathViewController = 'news.pages.rss.';
    private $controllerName     = 'rss';
    private $params = [];

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        view()->share('title', 'Tin Tức Tổng Hợp');
        $rssModel = new RssModel();
        $itemsRss = $rssModel->listItems(null, ['task' => 'news-list-items']);
        $data = Feed::read($itemsRss);
        return view($this->pathViewController . 'index', [
            'items' => $data,
        ]);
    }

    public function getGold()
    {
        $dataGold = Feed::getGold();
        return view($this->pathViewController . 'child-index.box-gold', [
            'items' => $dataGold,
        ]);
    }

    public function getCoin()
    {
        $dataCoin = Feed::getCoin();
        return view($this->pathViewController . 'child-index.box-coin', [
            'items' => $dataCoin,
        ]);
    }
}
