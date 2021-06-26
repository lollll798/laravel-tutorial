<?php

namespace App\Http\Controllers;

use App\Traits\CustomizeLog;
use App\UseCases\CustomizeLog\LogToFile;
use App\UseCases\CustomizeLog\LogToEmail;

class CustomizeLogController extends Controller
{
    use CustomizeLog;
    public function customizeLog()
    {
        $this->log([new LogToFile("File Test"), new LogToEmail("Email Test", 'Subject Title')]);
        return 'Finished';
    }
}
