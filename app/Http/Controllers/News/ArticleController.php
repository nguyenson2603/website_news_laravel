<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $pathViewController = 'news.pages.article.';
    private $controllerName     = 'article';
    private $params = [];

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $articleModel = new ArticleModel();
        $params['article_id'] = $request->article_id;
        $itemArticle = $articleModel->getItems($params, ['task' => 'news-get-item']);
        if(empty($itemArticle)) return redirect()->route('home');
        $params['category_id'] = $itemArticle['category_id'];
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $itemArticle['related_articles'] = $articleModel->listItems($params, ['task' => 'news-list-items-related-in-category']);
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'itemsLatest' => $itemsLatest,
            'itemArticle' => $itemArticle,
        ]);
    }
}
