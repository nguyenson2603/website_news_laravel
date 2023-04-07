<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminModel extends Model
{
    protected $table        = '';
    protected $folderUpload = '';
    public $timestamps      = false;
    const CREATED_AT        = 'created';
    const UPDATED_AT        = 'modified';
    protected $fieldSearchAccepted = [
        'id', 'name',
    ];
    protected $crudNotAccepted = [
        '_token',
        'thumb_current',
    ];

    public function uploadThumb($thumb)
    {
        $thumbName = Str::random(10) . '.' . $thumb->clientExtension();
        $thumb->storeAs($this->folderUpload, $thumbName, 'zvn');
        return $thumbName;
    }

    public function deleteThumb($thumbName)
    {
        Storage::disk('zvn')->delete($this->folderUpload . '/' . $thumbName);
    }

    public function prepareParams($params)
    {
        return array_diff_key($params, array_flip($this->crudNotAccepted));
    }
}
