<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use OSS\Core\OssException;

class UploadTool extends Model
{
    //
    public static function upload($fileName)
    {
        //上传文件类
        /**
         * 上传指定的本地文件内容
         *
         * @param OssClient $ossClient OSSClient实例
         * @param string $bucket 存储空间名称
         * @return null
         */
        $client = App::make('aliyun-oss');

        $prefix =  'https://zhou-laravel-shop.oss-cn-beijing.aliyuncs.com/';
        $dirname = strstr($fileName,'storage');
        $path = storage_path().'/app/public/'.substr($dirname,8);
        try{
            $client->uploadFile(getenv('OSS_BUCKET'),$dirname,$path);
            return  $prefix.$dirname;
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
            return;
        }
    }

}
