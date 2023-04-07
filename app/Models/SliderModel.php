<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;

class SliderModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'slider';
        $this->folderUpload = 'slider';
        $this->fieldSearchAccepted = [
            'id', 'name', 'description', 'link',
        ];
        $this->crudNotAccepted = [
            '_token', 'thumb_current',
        ];
    }

    public function listItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select(
                'id',
                'name',
                'description',
                'link',
                'thumb',
                'created',
                'created_by',
                'modified',
                'modified_by',
                'status',
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
        if ($options['task'] == 'add-item') {
            $params = array_diff_key($params, array_flip($this->crudNotAccepted));
            $params['thumb'] = $this->uploadThumb($params['thumb']);
            $params['created_by'] = 'Son Nguyen';
            $params['created'] = date('Y-m-d');
            $this->insert($this->prepareParams($params));
        }
        if ($options['task'] == 'edit-item') {
            if (isset($params['thumb'])) {
                $this->deleteThumb($params['thumb_current']);
                $params['thumb'] = $this->uploadThumb($params['thumb']);
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
            $item = $this->getItems($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            $this->where('id', $params['id'])->delete();
        }
        return $result;
    }

    public function getItems($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = $this->select('id', 'name', 'description', 'status', 'link', 'thumb')
                ->where('id', $params['id'])->get()->toArray();
        }
        if ($options['task'] == 'get-thumb') {
            $result = $this->select('id', 'thumb')
                ->where('id', $params['id'])->first()->toArray();
        }
        return $result;
    }
}
