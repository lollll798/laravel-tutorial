<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait Log {
    public function log($msg = null, $document = 'log.txt')
    {
        $now = Carbon::now();
        $exists = Storage::disk('local')->exists($document);
        if($exists){
            Storage::prepend($document, '['.$now->toDateTimeString().' | '.$now->getTimezone()->getName().'] '.json_encode($msg));
        } else {
            Storage::disk('local')->put($document, '['.$now->toDateTimeString().' | '.$now->getTimezone()->getName().'] '.json_encode($msg));
        }
    }
}
