<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest as MainRequest;
use App\Models\UserModel as MainModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $pathViewController = 'admin.pages.user.';
    private $controllerName     = 'user';
    private $params = [];
    private $model;

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params['pagination']['totalItemPerPage'] = 4;
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

    public function changePassword(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $this->model->saveItems($params, ['task' => 'change-password']);
            return redirect()->route($this->controllerName)->with('zvn_notify', 'Thay đổi mật khẩu thành công!');
        }
    }

    public function changeLevel(MainRequest $request)
    {
        if ($request->method() == 'POST') {
            $params = $request->all();
            $this->model->saveItems($params, ['task' => 'change-level-form']);
            return redirect()->route($this->controllerName)->with('zvn_notify', 'Thay đổi quyền người dùng thành công!');
        }
    }

    public function level(Request $request)
    {
        $id = $request->id;
        $level = $request->level;

        $this->params['level'] = [
            'curLevel' => $level,
            'id'     => $id,
        ];
        $this->model->saveItems($this->params, ['task' => 'change-level']);
        return redirect()->route($this->controllerName)->with('zvn_notify', "Item ID $id cập nhật level thành công!!");
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
}
