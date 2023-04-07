<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest as MainRequest;
use App\Models\ArticleModel as MainModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $pathViewController = 'admin.pages.article.';
    private $controllerName     = 'article';
    private $params = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params['pagination']['totalItemPerPage'] = 5;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status']   = $request->input('filter_status', 'all');
        $this->params['search']['field']    = $request->input('search_field', 'all');
        $this->params['search']['value']    = $request->input('search_value', '');
        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']);
        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount,
        ]);
    }

    public function form(Request $request)
    {
        $item[0] = null;
        $category = new CategoryModel();
        $params['category'] = $category->listItems(null, ['task' => 'admin-list-items-in-select-box']);
        if ($request->id !== null) {
            $params['id'] = $request->id;
            $item = $this->model->getItems($params, ['task' => 'get-item']);
        }
        return view($this->pathViewController . 'form', [
            'item' => $item[0],
            'category' => $params['category'],
        ]);
    }

    public function save(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();

            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            if ($params['id'] !== null) {
                $task   = 'edit-item';
                $notify = 'Cập nhật phần tử thành công!';
            }
            $this->model->saveItems($params, ['task' => $task]);
            return redirect()->route($this->controllerName)->with('zvn_notify', $notify);
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $this->params['id'] = $id;
        $this->model->deleteItems($this->params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('zvn_notify', "Item ID $id đã xóa thành công!!");
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $this->params['status'] = [
            'curStatus' => $status,
            'id'     => $id,
        ];
        $this->model->saveItems($this->params, ['task' => 'change-status']);
        return redirect()->route($this->controllerName)->with('zvn_notify', "Item ID $id cập nhật trạng thái thành công!!");
    }

    public function type(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        $this->params['type'] = [
            'curType' => $type,
            'id'     => $id,
        ];
        $this->model->saveItems($this->params, ['task' => 'change-type']);
        return redirect()->route($this->controllerName)->with('zvn_notify', "Item ID $id cập nhật hiển thị thành công!!");
    }
}
