<?php

namespace Codetrainee\SensitiveWords;

use Encore\Admin\Admin;
use Encore\Admin\Extension;

class Safe extends Extension
{
    public static function boot()
    {
        static::registerRoutes();
        Admin::extend('safe', __CLASS__);
    }

    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            $router->post('safe/check', 'Codetrainee\SensitiveWords\Http\Controller\SafeController@check');
        });
    }

}
