<?php

namespace Mysic\LaravelAdminApization\Http\Controllers;

use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class LaravelAdminApizationController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(view('laravel-admin-apization::index'));
    }
}