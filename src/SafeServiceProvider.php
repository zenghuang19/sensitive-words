<?php

namespace Codetrainee\SensitiveWords;

use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;
use Codetrainee\SensitiveWords\Form\Field\TextareaSafe;
use Codetrainee\SensitiveWords\Form\Field\TextSafe;
use Codetrainee\SensitiveWords\Form\Field\UrlSafe;

class SafeServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
//        if (!config('admin.extensions.safe.enable', 'true')) {
//            return;
//        }

//        Form::extend('textSafe', TextSafe::class);
//        Form::extend('textareaSafe', TextareaSafe::class);
//        Form::extend('urlSafe', UrlSafe::class);
//
//        Safe::boot();
    }
}
