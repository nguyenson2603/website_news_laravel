<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;

class RssModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'rss';
        $this->folderUpload = 'rss';
        $this->fieldSearchAccepted = [
            'id', 'name', 'link',
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
                'status',
                'link',
                'ordering',
                'source',
                'created',
                'created_by',
                'modified',
                'modified_by',
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
            $result = $query->orderBy('ordering', 'asc')->paginate($params['pagination']['totalItemPerPage']);
        }
        if ($options['task'] == 'news-list-items') {
            $query = $this->select('id', 'name', 'link', 'source')
                ->where('status', 'active')
                ->orderBy('ordering', 'asc');
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
            $result = $this->select('id', 'name', 'status', 'link', 'ordering', 'source')
                ->where('id', $params['id'])->get()->toArray();
        }
        return $result;
    }
}
