<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CertificateProduct extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', false)->select('url');
    }

    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', true)->select('url');
    }

    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }


    // fetchData
    public static function fetchData($value='')
    {
        // this way will fire up speed of the query
        $obj = self::query();


          // search for multiple columns..
          if(isset($value['search']) && $value['search']) {
            $obj->where(function($q) use ($value) {
                $q->where('title', 'like', '%'.$value['search'].'%');
                $q->orWhere('body', 'like', '%'.$value['search'].'%');
                $q->orWhere('id', $value['search']);
              });
          }

          // status
          if(isset($value['status']) && $value['status']) {
              if($value['status'] == 'active')
                  $obj->where(['status' => true, 'trash' => false]);
              else if ($value['status'] == 'inactive')
                  $obj->where(['status' => false, 'trash' => false]);
              else if ($value['status'] == 'trash')
                  $obj->where('trash', true);
          }

          // order By..
          if(isset($value['order']) && $value['order']) {
            if($value['order_by'] == 'title')
              $obj->orderBy('title', $value['order']);
            else if ($value['order_by'] == 'created_at')
              $obj->orderBy('created_at', $value['order']);
            else
              $obj->orderBy('id', $value['order']);
          } else {
            $obj->orderBy('sort', 'DESC');
          }

          // feel free to add any query filter as much as you want...

        $obj = $obj->paginate($value['paginate'] ?? 10);
        return $obj;
    }



    // createOrUpdate
    public static function createOrUpdate($id, $value)
    {
        try {
            
            DB::beginTransaction();

              // Row
              $row                = (isset($id)) ? self::findOrFail($id) : new self;
              $row->slug          = strtolower($value['slug']) ?? NULL;
              $row->title         = $value['title'] ?? NULL;
              $row->subtitle      = $value['subtitle'] ?? NULL;
              $row->short_body    = $value['short_body'] ?? NULL;
              $row->body          = $value['body'] ?? NULL;

              $row->bgTitle       = $value['bgTitle'] ?? NULL;
              $row->bgColor       = $value['bgColor'] ?? NULL;

              $row->title1         = $value['title1'] ?? NULL;
              $row->title2         = $value['title2'] ?? NULL;
              $row->title3         = $value['title3'] ?? NULL;
              $row->title4         = $value['title4'] ?? NULL;
              $row->title5         = $value['title5'] ?? NULL;

              $row->body1         = $value['body1'] ?? NULL;
              $row->body2         = $value['body2'] ?? NULL;
              $row->body3         = $value['body3'] ?? NULL;
              $row->body4         = $value['body4'] ?? NULL;
              $row->body5         = $value['body5'] ?? NULL;

              $row->sort          = (int)$value['sort'] ?? 0;
              $row->status        = (boolean)$value['status'] ?? false;
              $row->save();

              // Image
              if(isset($value['base64Image'])) {
                $row->image()->delete();
                if($value['base64Image']) {
                  if(!Str::contains($value['base64Image'], ['uploads','false'])) {
                    $image = Imageable::uploadImage($value['base64Image']);
                  } else {
                    $image = explode('/', $value['base64Image']);
                    $image = end($image);
                  }
                  $row->image()->create(['url' => $image]);
                }
              }

              if(isset($value['download_file'])) {
                $row->pdf()->delete();
                if($value['download_file']) {
                  if(!Str::contains($value['download_file'], ['uploads','false'])) {
                    $file = Imageable::uploadImage($value['download_file']);
                  } else {
                    $file = explode('/', $value['download_file']);
                    $file = end($file);
                  }
                  $row->pdf()->create(['url' => $file, 'is_pdf' => true]);
                }
              }

              if(isset($value['download_image'])) {
                $row->image_pdf()->delete();
                if($value['download_image']) {
                  if(!Str::contains($value['download_image'], ['uploads','false'])) {
                    $file2 = Imageable::uploadImage($value['download_image']);
                  } else {
                    $file2 = explode('/', $value['download_image']);
                    $file2 = end($file2);
                  }
                  $row->image_pdf()->create(['url' => $file2, 'is_pdf' => 2]);
                }
              }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

}
