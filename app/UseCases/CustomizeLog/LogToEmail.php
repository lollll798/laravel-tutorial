<?php

namespace App\UseCases\CustomizeLog;

use App\UseCases\CustomizeLog\Contracts\Log;
use Illuminate\Support\Facades\Mail;

class LogToEmail implements Log {
    private $msg;
    private $title;
    private $target;
    public function __construct($msg, $title, $target = null)
    {
        $this->title = $title;
        $this->msg = $msg;
        $this->target = $target;
    }

    public function log()
    {
        $title = $this->title?:'empty title';
        $supportMail = $this->target?:env('SUPPORT_MAIL');
        Mail::raw($this->msg, function ($message) use ($title, $supportMail){
            $message->to($supportMail);
            $message->subject($title);
        });
    }
}

