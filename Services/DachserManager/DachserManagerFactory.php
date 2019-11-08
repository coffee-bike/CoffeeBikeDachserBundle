<?php

namespace App\Factory;

use CoffeeBike\DachserBundle\Services\DachserManager;

class DachserManagerFactory
{

    public static function createDachserManager(array $credentials): DachserManager
    {
        return new DachserManager($credentials['username'], $credentials['password']);
    }
}
