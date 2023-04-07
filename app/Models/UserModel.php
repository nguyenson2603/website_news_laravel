<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;

class UserModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'user';
        $this->folderUpload = 'user';
        $this->fieldSearchAccepted = [
            'id', 'username', 'email', 'fullname',
        ];
        $this->crudNotAccepted = [
            '_token', 'avatar_current', 'password_confirmation', 'task',
        ];
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select(
                'id',
                'username',
                'email',
                'fullname',
                'avatar',
                'status',
                'level',
                'created',
                'created_by',
                'modified',
                'modified_by'
            );
            if ($params['filter']['status'] !== 'all') {
                $query->where('status', '=', $params['filter']['status']);
            }
            if ($params['search']['value'] !== null) {
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $colum) {
                            $query->orWhere($colum, 'LIKE', '%' . $params['search']['value'] . '%');
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', '%' . $params['search']['value'] . '%');
                }
            }
            $result = $query->orderBy('id', 'desc')->paginate($params['pagination']['totalItemPerPage']);
        }
        if ($options['task'] == 'news-list-items') {
            $query = $this->select('id', 'name', 'description', 'link', 'thumb')
                ->where('status', 'active')->limit(5);
            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function countItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-count-items-group-by-status') {
            $query = $this->select(DB::raw('status, COUNT(id) as count'));
            if ($params['search']['value'] !== null) {
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $colum) {
                            $query->orWhere($colum, 'LIKE', '%' . $params['search']['value'] . '%');
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', '%' . $params['search']['value'] . '%');
                }
            }
            $result = $query->groupBy('status')->get()->toArray();
        }
        return $result;
    }

    public function saveItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'change-status') {
            $status = ($params['status']['curStatus'] == 'active') ? 'inactive' : 'active';
            $this->where('id', $params['status']['id'])
                ->update(['status' => $status]);
        }
        if ($options['task'] == 'change-level') {
            $this->where('id', $params['level']['id'])
                ->update(['level' => $params['level']['curLevel']]);
        }
        if ($options['task'] == 'change-password') {
            $params['password'] = md5($params['password']);
            $this->where('id', $params['id'])
                ->update(['password' => $params['password']]);
        }
        if ($options['task'] == 'change-level-form') {
            $this->where('id', $params['id'])
                ->update(['level' => $params['level']]);
        }
        if ($options['task'] == 'add-item') {
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            $params['avatar'] = $this->uploadThumb($params['avatar']);
            $params['created_by'] = 'Son Nguyen';
            $params['created'] = date('Y-m-d');
            $params['password'] = md5($params['password']);
            $this->insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            if (isset($params['avatar'])) {
                $this->deleteThumb($params['avatar_current']);
                $params['avatar'] = $this->uploadThumb($params['avatar']);
            }
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            $params['modified_by'] = 'Son Nguyen';
            $params['modified'] = date('Y-m-d');
            $this->where('id', $params['id'])->update($this->prepareParams($params));
        }
        return $result;
    }

    public function deleteItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'delete-item') {
            $item = $this->getItems($params, ['task' => 'get-avatar']);
            $this->deleteThumb($item['avatar']);
            $this->where('id', $params['id'])->delete();
        }
        return $result;
    }

    public function getItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = $this->select('id', 'username', 'password', 'email', 'status', 'level', 'fullname', 'avatar')
                ->where('id', $params['id'])->get()->toArray();
        }
        if ($options['task'] == 'get-avatar') {
            $result = $this->select('id', 'avatar')
                ->where('id', $params['id'])->first()->toArray();
        }
        if ($options['task'] == 'auth-login') {
            $result = $this->select('id', 'username', 'fullname', 'email', 'level', 'avatar')
                ->where('status', 'active')
                ->where('username', $params['username'])
                ->where('password', md5($params['password']))->first();
            if($result) $result = $result->toArray();
        }
        return $result;
    }
}
