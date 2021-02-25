<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image as Image;

class Imageable extends Model
{   

    protected $guarded = [];
    
    public function imageable() {
        return $this->morphTo();
    }

    public static function uploadFile($file, $path, $key=0)
    {

        $base64_str   = substr($file, strpos($file, ",")+1);
        $imageDecoded = base64_decode($base64_str);

        if(explode(';', $file)[0]) {
            $imageFormat   = explode(';', $file)[0];
            $imageFormat   = explode('/', $imageFormat)[1];
            if ($imageFormat == 'svg+xml') {
                $imageFormat = 'svg';
            }
        }

        $fileName  = date('Y-m-d-h-i-s').'-'.$key.uniqid().'-original.'.$imageFormat;
        Storage::disk('public')->put('uploads/' . $path .'/'. $fileName, $imageDecoded);
        //Storage::disk('s3')->put('/' . $path .'/'. $fileName, $imageDecoded);
        return $fileName;
    }

    public static function getImagePath($path, $image)
    {
        return self::baseURL() . $path .'/'.$image;
    }

    public static function contains($value='')
    {
        return 'uploads/';
        //return 's3.eu-central-1.amazonaws.com/';
    }

    public static function baseURL()
    {
        return request()->root() . '/uploads/';
        //return 'https://s3.eu-central-1.amazonaws.com/storageName/';
    }

    public static function deleteFile() {
        //
    }
}
