<?php

namespace Mysic\LaravelAdminApization\Widgets;

use Encore\Admin\Layout\Content;
use Mysic\LaravelAdminApization\Layout\Content as MysicLayoutContent;

class Form extends \Encore\Admin\Widgets\Form
{
    protected $renderMode;

    public function __construct($data = [])
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($data);
    }

    public function render()
    {
        if($this->renderMode == 'api') {
            return $this->getVariables();
        }
        return parent::render();
    }

    protected function getVariables(): array
    {
        if($this->renderMode == 'api') {
            return $this->data();
        }
        return parent::getVariables();
    }

    public function __invoke(Content $content)
    {
        if($this->renderMode == 'api') {
            $newContent = app()->make(MysicLayoutContent::class);
            return $newContent->title($this->title())
                ->description($this->description())
                ->body($this);
        }
        return parent::__invoke($content);
    }
}
