<?php

namespace App\UseCases\Facades;

use Illuminate\Support\Facades\Mail;

class PostcardSendingService
{
    private $_country;
    private $_width;
    private $_height;

    public function __construct($country, $width, $height)
    {
        $this->_country = $country;
        $this->_width = $width;
        $this->_height = $height;
    }

    public function hello($message, $email)
    {
        Mail::raw($message, function($message) use ($email) {
            $message->to($email);
        });

        dump('Postcard email send with message: '.$message);
    }
}

