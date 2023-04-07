<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $pathViewController = 'news.pages.category.';
    private $controllerName     = 'category';
    private $params = [];

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();
        $params['category_id'] = $request->category_id;
        // Danh sách bài viết (Article)
        $itemsCategory = $categoryModel->getItems($params, ['task' => 'news-get-items']);
        if(empty($itemsCategory)) return redirect()->route('home');
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        $itemsCategory['article'] = $articleModel->listItems(['category_id' => $itemsCategory['id']], ['task' => 'news-list-items-in-category-full']);
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'itemsLatest' => $itemsLatest,
            'itemsCategory' => $itemsCategory,
        ]);
    }
}
