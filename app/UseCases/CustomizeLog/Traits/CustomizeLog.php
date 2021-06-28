<?php

namespace App\UseCases\CustomizeLog\Traits;

use App\UseCases\CustomizeLog\Logger;

trait CustomizeLog {
    public function log($logType)
    {
        $loggers = new Logger;
        $loggers->attach($logType);
        $loggers->execute();
    }
}

