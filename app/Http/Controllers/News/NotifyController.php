<?php

namespace App\Http\Controllers\News;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ArticleModel;

class NotifyController extends Controller
{
    private $pathViewController = 'news.pages.notify.';
    private $controllerName     = 'notify';
    private $params = [];

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function noPermission(Request $request){
        $articleModel = new ArticleModel();
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        return view($this->pathViewController . 'no-permission', [
            'itemsLatest' => $itemsLatest,
        ]);
    }
}
