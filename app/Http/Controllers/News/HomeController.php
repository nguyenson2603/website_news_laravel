<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\SliderModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $pathViewController = 'news.pages.home.';
    private $controllerName     = 'home';
    private $params = [];

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $sliderModel = new SliderModel();
        $categoryModel = new CategoryModel();
        $articleModel = new ArticleModel();

        // Danh sách Slider
        $itemsSlider = $sliderModel->listItems(null, ['task' => 'news-list-items']);
        // Danh sách thể loại (Category)
        $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items-is-home']);
        // Danh sách bài viết (Article)
        $itemsFeatured = $articleModel->listItems(null, ['task' => 'news-list-items-featured']);
        $itemsLatest = $articleModel->listItems(null, ['task' => 'news-list-items-latest']);
        foreach ($itemsCategory as $key => $category) {
            $itemsCategory[$key]['article'] = $articleModel->listItems(['category_id' => $category['id']], ['task' => 'news-list-items-in-category']);
        }
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'itemsSlider' => $itemsSlider,
            'itemsCategory' => $itemsCategory,
            'itemsFeatured' => $itemsFeatured,
            'itemsLatest' => $itemsLatest,
        ]);
    }
}
