<?php

namespace App\UseCases\CustomizeLog;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Contracts\Log;

class LogToFile implements Log {
    private $msg;
    private $document;
    public function __construct($msg, $document = 'customize_log.txt')
    {
        $this->document = $document;
        $this->msg = $msg;
    }

    public function log()
    {
        $now = Carbon::now();
        $exists = Storage::disk('local')->exists($this->document);
        $user = isset(Auth::user()->id_user) == true? Auth::user()->id_user : '';
        if($exists){
            Storage::prepend($this->document, '['.$now->toDateTimeString().' | '.$now->getTimezone()->getName().'][ID User:'.$user.'] '.json_encode($this->msg));
        } else {
            Storage::disk('local')->put($this->document, '['.$now->toDateTimeString().' | '.$now->getTimezone()->getName().'][ID User:'.$user.'] '.json_encode($this->msg));
        }
    }
}
