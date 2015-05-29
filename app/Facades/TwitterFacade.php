<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TwitterFacade extends Facade {

    /**
     * @return string
     */
    public static function getFacadeAccessor(){
        return 'twitter';
    }
}