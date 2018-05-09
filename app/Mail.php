<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    //
    //email
    static public function send($name,$email_post)
    {
        \Illuminate\Support\Facades\Mail::send(
            'Mail.mail',
            ['name'=>$name],
            function ($message)use($email_post){
                $message->to($email_post)->subject('注册确认');
            }
        );
        return 'success';
    }

}
