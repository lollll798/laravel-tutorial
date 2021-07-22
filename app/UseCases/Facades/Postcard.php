<?php

namespace App\UseCases\Facades;

class Postcard
{
    protected static function resolveFacade($name)
    {
        // app()->make('Postcard')
        return app()[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        return (self::resolveFacade('Postcard'))
            ->$method(...$arguments);
    }
}

