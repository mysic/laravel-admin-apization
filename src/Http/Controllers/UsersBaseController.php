<?php

namespace Mysic\LaravelAdminApization\Http\Controllers;

use Mysic\LaravelAdminApization\ResponseMessage;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController as ParentAdminController;
use Mysic\LaravelAdminApization\Layout\Content as MysicLayoutContent;

class UsersBaseController extends ParentAdminController
{
    use ResponseMessage;

    protected $renderMode;

    public function __construct()
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
    }


    public function index(Content $content)
    {
        if($this->renderMode == 'api') {
            $apiContent = app()->make(MysicLayoutContent::class);
            return $apiContent
                ->title($this->title())
                ->description($this->description['index'] ?? trans('admin.list'))
                ->body($this->grid());
        }
        return parent::index($content);
    }

    public function show($id, Content $content)
    {
        if($this->renderMode == 'api') {
            $apiContent = app()->make(MysicLayoutContent::class);
            return $apiContent
                ->title($this->title())
                ->description($this->description['show'] ?? trans('admin.show'))
                ->body($this->detail($id));
        }
        return parent::show($id, $content);
    }

    public function edit($id, Content $content)
    {
        if($this->renderMode == 'api') {
            $apiContent = app()->make(MysicLayoutContent::class);
            return $apiContent
                ->title($this->title())
                ->description($this->description['edit'] ?? trans('admin.edit'))
                ->body($this->form()->edit($id));
        }
        return parent::edit($id, $content);
    }

    public function create(Content $content)
    {
        if($this->renderMode == 'api') {
            $apiContent = app()->make(MysicLayoutContent::class);
            return $apiContent
                ->title($this->title())
                ->description($this->description['create'] ?? trans('admin.create'))
                ->body($this->form());
        }
        return parent::create($content);
    }
}
