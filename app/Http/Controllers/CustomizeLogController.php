<?php

namespace App\Http\Controllers;

use App\UseCases\CustomizeLog\LogToFile;
use App\UseCases\CustomizeLog\LogToEmail;
use App\UseCases\CustomizeLog\Traits\CustomizeLog;

class CustomizeLogController extends Controller
{
    use CustomizeLog;
    public function customizeLog()
    {
        $this->log([new LogToFile("File Test"), new LogToEmail("Email Test", 'Subject Title')]);
        return 'Finished';
    }
}
