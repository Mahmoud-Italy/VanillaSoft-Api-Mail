<?php

namespace App\Models;

use DB;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $guarded = [];

    public function image() {
        return $this->morphOne(Imageable::class, 'imageable')
                  ->where('type', false)
                  ->where('is_pdf', false)
                  ->select('url');
    }

    public function image1_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 1)->select('url');
    }
    public function image1_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 2)->select('url');
    }
    public function image1_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 3)->select('url');
    }
    public function image1_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 4)->select('url');
    }

    public function image2_1() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 5)->select('url');
    }
    public function image2_2() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 6)->select('url');
    }
    public function image2_3() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 7)->select('url');
    }
    public function image2_4() {
        return $this->morphOne(Imageable::class, 'imageable')->where('type', 8)->select('url');
    }

    public function image_pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 2)->select('url');
    }
    public function pdf() {
        return $this->morphOne(Imageable::class, 'imageable')->where('is_pdf', 1)->select('url');
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
              $row->bgTitle       = $value['bgTitle'] ?? NULL;
              $row->bgColor       = $value['bgColor'] ?? NULL;

              $row->body1         = $value['body1'] ?? NULL;
              $row->body2         = $value['body2'] ?? NULL;
              $row->body3         = $value['body3'] ?? NULL;
              $row->body4         = $value['body4'] ?? NULL;
              $row->body5         = $value['body5'] ?? NULL;

              $row->body1_1       = $value['body1_1'] ?? NULL;
              $row->body1_2       = $value['body1_2'] ?? NULL;
              $row->body1_3       = $value['body1_3'] ?? NULL;
              $row->body1_4       = $value['body1_4'] ?? NULL;

              $row->body2_1       = $value['body2_1'] ?? NULL;
              $row->body2_1_r     = $value['body2_1_r'] ?? NULL;
              $row->label2_1      = $value['label2_1'] ?? NULL;
              $row->color2_1      = $value['color2_1'] ?? NULL;
              $row->body2_2       = $value['body2_2'] ?? NULL;
              $row->body2_2_r     = $value['body2_2_r'] ?? NULL;
              $row->label2_2      = $value['label2_2'] ?? NULL;
              $row->color2_2      = $value['color2_2'] ?? NULL;
              $row->body2_3       = $value['body2_3'] ?? NULL;
              $row->body2_3_r     = $value['body2_3_r'] ?? NULL;
              $row->label2_3      = $value['label2_3'] ?? NULL;
              $row->color2_3      = $value['color2_3'] ?? NULL;
              $row->body2_4       = $value['body2_4'] ?? NULL;
              $row->body2_4_r     = $value['body2_4_r'] ?? NULL;
              $row->label2_4      = $value['label2_4'] ?? NULL;
              $row->color2_4      = $value['color2_4'] ?? NULL;


              $row->has_faq         = (isset($value['has_faq']) && $value['has_faq']) 
                                        ? (boolean)$value['has_faq'] : false;
              $row->faq_link       = (isset($value['faq_link']) && $value['faq_link']) 
                                        ? $value['faq_link'] : NULL;


              $row->has_application  = (isset($value['has_application']) && $value['has_application'])
                                        ? (boolean)$value['has_application'] : false;
              $row->application_name = (isset($value['application_name']) && $value['application_name']) 
                                        ? $value['application_name'] : NULL;
              $row->application_path = (isset($value['application_path']) && $value['application_path']) 
                                        ? $value['application_path'] : NULL;
                                        
                                        
              $row->has_download    = (isset($value['has_download']) && $value['has_download']) 
                                        ? (boolean)$value['has_download']  : false;
              $row->download_name   = $value['download_name'] ?? NULL;


              $row->has_payment     = (isset($value['has_payment']) && $value['has_payment'])
                                        ? (boolean)$value['has_payment'] : false;
              $row->payment_name    = (isset($value['payment_name']) && $value['payment_name']) 
                                        ? $value['payment_name'] : NULL;
              $row->payment_link    = (isset($value['payment_link']) && $value['payment_link']) 
                                        ? $value['payment_link'] : NULL;

              $row->sort          = (int)$value['sort'] ?? 0;
              $row->status        = (isset($value['status']) && $value['status']) 
                                      ? (boolean)$value['status'] 
                                      : false;
              $row->save();

              // Image
              if(isset($value['image'])) {
                $row->image()->delete();
                if($value['image']) {
                  if(!Str::contains($value['image'], ['uploads','false'])) {
                    $image = Imageable::uploadImage($value['image']);
                  } else {
                    $image = explode('/', $value['image']);
                    $image = end($image);
                  }
                  $row->image()->create(['url' => $image]);
                }
              }


              if(isset($value['image1_1'])) {
                $row->image1_1()->delete();
                if($value['image1_1']) {
                  if(!Str::contains($value['image1_1'], ['uploads','false'])) {
                    $image1_1 = Imageable::uploadImage($value['image1_1']);
                  } else {
                    $image1_1 = explode('/', $value['image1_1']);
                    $image1_1 = end($image1_1);
                  }
                  $row->image1_1()->create(['url' => $image1_1, 'type' => 1]);
                }
              }

              if(isset($value['image1_2'])) {
                $row->image1_2()->delete();
                if($value['image1_2']) {
                  if(!Str::contains($value['image1_2'], ['uploads','false'])) {
                    $image1_2 = Imageable::uploadImage($value['image1_2']);
                  } else {
                    $image1_2 = explode('/', $value['image1_2']);
                    $image1_2 = end($image1_2);
                  }
                  $row->image1_2()->create(['url' => $image1_2, 'type' => 2]);
                }
              }

              if(isset($value['image1_3'])) {
                $row->image1_3()->delete();
                if($value['image1_3']) {
                  if(!Str::contains($value['image1_3'], ['uploads','false'])) {
                    $image1_3 = Imageable::uploadImage($value['image1_3']);
                  } else {
                    $image1_3 = explode('/', $value['image1_3']);
                    $image1_3 = end($image1_3);
                  }
                  $row->image1_3()->create(['url' => $image1_3, 'type' => 3]);
                }
              }

              if(isset($value['image1_4'])) {
                $row->image1_4()->delete();
                if($value['image1_4']) {
                  if(!Str::contains($value['image1_4'], ['uploads','false'])) {
                    $image1_4 = Imageable::uploadImage($value['image1_4']);
                  } else {
                    $image1_4 = explode('/', $value['image1_4']);
                    $image1_4 = end($image1_4);
                  }
                  $row->image1_4()->create(['url' => $image1_4, 'type' => 4]);
                }
              }
              






              if(isset($value['image2_1'])) {
                $row->image2_1()->delete();
                if($value['image2_1']) {
                  if(!Str::contains($value['image2_1'], ['uploads','false'])) {
                    $image2_1 = Imageable::uploadImage($value['image2_1']);
                  } else {
                    $image2_1 = explode('/', $value['image2_1']);
                    $image2_1 = end($image2_1);
                  }
                  $row->image2_1()->create(['url' => $image2_1, 'type' => 5]);
                }
              }

              if(isset($value['image2_2'])) {
                $row->image2_2()->delete();
                if($value['image2_2']) {
                  if(!Str::contains($value['image2_2'], ['uploads','false'])) {
                    $image2_2 = Imageable::uploadImage($value['image2_2']);
                  } else {
                    $image2_2 = explode('/', $value['image2_2']);
                    $image2_2 = end($image2_2);
                  }
                  $row->image2_2()->create(['url' => $image2_2, 'type' => 6]);
                }
              }

              if(isset($value['image2_3'])) {
                $row->image2_3()->delete();
                if($value['image2_3']) {
                  if(!Str::contains($value['image2_3'], ['uploads','false'])) {
                    $image2_3 = Imageable::uploadImage($value['image2_3']);
                  } else {
                    $image2_3 = explode('/', $value['image2_3']);
                    $image2_3 = end($image2_3);
                  }
                  $row->image2_3()->create(['url' => $image2_3, 'type' => 7]);
                }
              }

              if(isset($value['image2_4'])) {
                $row->image2_4()->delete();
                if($value['image2_4']) {
                  if(!Str::contains($value['image2_4'], ['uploads','false'])) {
                    $image2_4 = Imageable::uploadImage($value['image2_4']);
                  } else {
                    $image2_4 = explode('/', $value['image2_4']);
                    $image2_4 = end($image2_4);
                  }
                  $row->image2_4()->create(['url' => $image2_4, 'type' => 8]);
                }
              }


              if(isset($value['download_file'])) {
                $row->pdf()->delete();
                if($value['download_file']) {
                  if(!Str::contains($value['download_file'], ['uploads','false'])) {
                    $pdf = Imageable::uploadImage($value['download_file']);
                  } else {
                    $pdf = explode('/', $value['download_file']);
                    $pdf = end($pdf);
                  }
                  $row->pdf()->create(['url' => $pdf, 'is_pdf' => 1]);
                }
              }
              if(isset($value['download_image'])) {
                $row->image_pdf()->delete();
                if($value['download_image']) {
                  if(!Str::contains($value['download_image'], ['uploads','false'])) {
                    $image_pdf = Imageable::uploadImage($value['download_image']);
                  } else {
                    $image_pdf = explode('/', $value['download_image']);
                    $image_pdf = end($image_pdf);
                  }
                  $row->image_pdf()->create(['url' => $image_pdf, 'is_pdf' => 2]);
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
