<?php

namespace App\UseCases\CustomizeLog;

use App\UseCases\CustomizeLog\Contracts\Log;
use App\UseCases\CustomizeLog\Contracts\ObserverSubjects;

class Logger implements ObserverSubjects {

    protected $observers = [];

    public function attach($observables)
    {
        if (is_array($observables)) {
            $this->attachObserver($observables);
        } else {
            $this->observers[] = $observables;
        }
    }

    public function execute()
    {
        foreach ($this->observers as $observer) {
            $observer->log();
        }
    }

    private function attachObserver($observables)
    {
        foreach ($observables as $observer) {
            if (!$observer instanceof Log) {
                continue;
            }
            $this->attach($observer);
        }
    }
}

