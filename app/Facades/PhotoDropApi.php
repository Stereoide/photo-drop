<?php

namespace App\Facades;

class PhotoDrop extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return 'photodrop';
    }
}