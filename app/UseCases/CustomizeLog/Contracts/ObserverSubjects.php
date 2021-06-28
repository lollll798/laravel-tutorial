<?php

namespace App\UseCases\CustomizeLog\Contracts;

interface ObserverSubjects {
    public function attach($observables);

    public function execute();
}
