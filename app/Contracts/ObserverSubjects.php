<?php

namespace App\Contracts;

interface ObserverSubjects {
    public function attach($observables);

    public function execute();
}
