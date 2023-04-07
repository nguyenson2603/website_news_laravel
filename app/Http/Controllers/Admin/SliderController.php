<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest as MainRequest;
use App\Models\SliderModel as MainModel;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $pathViewController = 'admin.pages.slider.';
    private $controllerName     = 'slider';
    private $params = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params['pagination']['totalItemPerPage'] = 2;
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
        if ($request->id !== null) {
            $params['id'] = $request->id;
            $item = $this->model->getItems($params, ['task' => 'get-item']);
        }
        return view($this->pathViewController . 'form', ['item' => $item[0]]);
    }

    public function save(MainRequest $request)
    {
        if($request->method() == 'POST'){
            $params = $request->all();

            $task   = 'add-item';
            $notify = 'Thêm phần tử thành công!';

            if($params['id'] !== null){
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
        $st = $status == 'active' ? 'inactive' : 'active';
        $link = route($this->controllerName . '/status', ['id' => $id, 'status' => $st]);
        return response()->json([
            'link' => $link,
            'status' => config('zvn.template.status.' . $st),
        ]);
    }
}
