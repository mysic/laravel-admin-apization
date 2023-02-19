<?php

namespace Mysic\LaravelAdminApization\Layout;


use Mysic\LaravelAdminApization\Grid;
use Illuminate\Contracts\Support\Renderable;

class Column extends \Encore\Admin\Layout\Column
{
    protected $renderMode;

    public function __construct($content, $width = 12)
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($content, $width);

    }

    public function build()
    {
        if($this->renderMode == 'api') {
            $data = [];
            foreach ($this->contents as $content) {
                if ($content instanceof Renderable || $content instanceof Grid) {
                    $data = $content->render();
                } else {
                    $data = $content;
                }

            }
            return $data;
        }
        parent::build();
    }
}
