<?php

namespace Mysic\LaravelAdminApization;

use Encore\Admin\Extension;

class LaravelAdminApization extends Extension
{
    public $name = 'laravel-admin-apization';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Laraveladminapization',
        'path'  => 'laravel-admin-apization',
        'icon'  => 'fa-gears',
    ];
}