<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;

class CategoryModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'category';
        $this->folderUpload = 'category';
        $this->fieldSearchAccepted = [
            'id', 'name',
        ];
        $this->crudNotAccepted = [
            '_token',
        ];
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select(
                'id',
                'name',
                'created',
                'created_by',
                'modified',
                'modified_by',
                'status',
                'is_home',
                'display',
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
            $query = $this->select('id', 'name')
                ->where('status', 'active')->limit(8);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-is-home') {
            $query = $this->select('id', 'name', 'display')
                ->where('status', 'active')->where('is_home', '1')->limit(3);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'admin-list-items-in-select-box') {
            $query = $this->select('id', 'name')
                ->where('status', 'active');
            $result = $query->pluck('name', 'id')->toArray();
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
        if ($options['task'] == 'change-is-home') {
            $isHome = ($params['isHome']['curIsHome'] == '0') ? '1' : '0';
            $this->where('id', $params['isHome']['id'])
                ->update(['is_home' => $isHome]);
        }
        if ($options['task'] == 'change-display') {
            $this->where('id', $params['display']['id'])
                ->update(['display' => $params['display']['curDisplay']]);
        }
        if ($options['task'] == 'add-item') {
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            $params['created_by'] = 'Son Nguyen';
            $params['created'] = date('Y-m-d');
            $this->insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
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
            $this->where('id', $params['id'])->delete();
        }
        return $result;
    }

    public function getItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = $this->select('id', 'name', 'status')
                ->where('id', $params['id'])->get()->toArray();
        }
        if ($options['task'] == 'get-thumb') {
            $result = $this->select('id', 'thumb')
                ->where('id', $params['id'])->first()->toArray();
        }
        if ($options['task'] == 'news-get-items') {
            $result = $this->select('id', 'name', 'display')
                ->where('id', $params['category_id'])->first();
            if($result) $result = $result->toArray();
        }
        return $result;
    }
}
