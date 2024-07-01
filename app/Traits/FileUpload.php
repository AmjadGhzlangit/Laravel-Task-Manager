<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileUpload
{
    public function uploadFile($model, UploadedFile $file, $collection = 'default')
    {
        $model->addMedia($file)->toMediaCollection($collection);
    }
}
