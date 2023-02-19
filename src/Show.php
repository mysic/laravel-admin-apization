<?php

namespace Mysic\LaravelAdminApization;

class Show extends \Encore\Admin\Show
{
    protected $renderMode;
    public function __construct($model, $builder = null)
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($model, $builder);
    }
}
