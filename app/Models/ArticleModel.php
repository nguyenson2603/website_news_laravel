<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Storage;

class ArticleModel extends AdminModel
{
    public function __construct()
    {
        $this->table = 'article as a';
        $this->folderUpload = 'article';
        $this->fieldSearchAccepted = [
            'name', 'content',
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
                'a.id',
                'a.name',
                'a.content',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.modified',
                'a.modified_by',
                'a.status',
                'a.type',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id');
            if ($params['filter']['status'] !== 'all') {
                $query->where('a.status', '=', $params['filter']['status']);
            }
            if ($params['search']['value'] !== null) {
                if ($params['search']['field'] == 'all') {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->fieldSearchAccepted as $colum) {
                            $query->orWhere('a.' . $colum, 'LIKE', '%' . $params['search']['value'] . '%');
                        }
                    });
                } else if (in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('a.' . $params['search']['field'], 'LIKE', '%' . $params['search']['value'] . '%');
                }
            }
            $result = $query->orderBy('a.id', 'desc')->paginate($params['pagination']['totalItemPerPage']);
        }
        if ($options['task'] == 'news-list-items-featured') {
            $query = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.category_id',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', 'active')
                ->where('a.type', 'featured')
                ->orderBy('a.id', 'desc')
                ->take(3);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-latest') {
            $query = $this->select(
                'a.id',
                'a.name',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.category_id',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', 'active')
                ->orderBy('a.id', 'desc')
                ->take(4);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-in-category') {
            $query = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.category_id',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', 'active')
                ->where('a.category_id', $params['category_id'])
                ->orderBy('a.id', 'desc')
                ->take(2);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-in-category-full') {
            $query = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.category_id',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', 'active')
                ->where('a.category_id', $params['category_id'])
                ->orderBy('a.id', 'desc');
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'news-list-items-related-in-category') {
            // echo '<h2>' . __METHOD__ . '</h2>';
            $query = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.thumb',
                'a.created',
                'a.created_by',
                'a.category_id',
                'c.name as category_name',
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', 'active')
                ->where('a.id', '!=', $params['article_id'])
                ->where('a.category_id', $params['category_id'])
                ->take(4);
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
        if ($options['task'] == 'change-type') {
            $this->where('id', $params['type']['id'])
                ->update(['type' => $params['type']['curType']]);
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
            $result = $this->select('id', 'name', 'content', 'status', 'thumb', 'category_id')
                ->where('id', $params['id'])->get()->toArray();
        }
        if ($options['task'] == 'get-thumb') {
            $result = $this->select('id', 'thumb')
                ->where('id', $params['id'])->first()->toArray();
        }
        if ($options['task'] == 'news-get-item') {
            $result = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.category_id',
                'c.name as category_name',
                'c.display',
                'a.thumb',
                'a.created',
                'a.created_by'
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.id', $params['article_id'])
                ->where('a.status', 'active')->first();
            if ($result) $result = $result->toArray();
        }
        return $result;
    }
}
