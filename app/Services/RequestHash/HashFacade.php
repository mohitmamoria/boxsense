<?php

namespace App\Services\RequestHash;

use Illuminate\Support\Facades\Facade;

class HashFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\RequestHash\Hash';
    }
}
