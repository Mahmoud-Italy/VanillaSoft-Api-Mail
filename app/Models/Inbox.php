<?php

namespace App\Models;

use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Models\Imageable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $guarded = [];

    public function attachments() {
        return $this->morphMany(Imageable::class, 'imageable');
    }


    public static function createOrUpdate($id=NULL)
    {
        try {

                // content
                $row           = new self;
                $row->to       = implode(",", request('to'));
                $row->subject  = request('subject');
                $row->body     = request('body');
                $row->save();


                // attachments
                if(request('attachments')) {
                    $row->attachments()->delete();
                    foreach (request('attachments') as $key => $attach) {
                        if($attach && $attach['attach_filebase64']) {
                            $image = Imageable::uploadFile($attach['attach_filebase64'], 'inbox', $key);
                            
                            $row->attachments()->create([ 
                                'url'  => $image, 
                                'name' => $attach['attach_name']
                            ]);
                        }
                    }
                }


                // dispatch emails
                $this->enqueue($row);

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function enqueue($row)
    {
        $emailJob = (new SendEmail($row))->delay(Carbon::now()->addMinutes(1)); // delay 1min
        dispatchNow($emailJob);
    }

}
