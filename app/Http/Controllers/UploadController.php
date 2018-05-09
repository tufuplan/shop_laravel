<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use OSS\Core\OssException;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $fileName = $request->file('file')->store('public/dish');
        return ['url'=>url(Storage::url($fileName))];
    }
}
