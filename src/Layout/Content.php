<?php

namespace Mysic\LaravelAdminApization\Layout;

use Closure;

class Content extends \Encore\Admin\Layout\Content
{
    protected $renderMode;
    public function __construct(Closure $callback = null)
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($callback);
    }

    public function row($content)
    {
        if($this->renderMode == 'api') {
            if ($content instanceof Closure) {
                $row = new Row();
                call_user_func($content, $row);
                $this->addRow($row);
            } else {
                $this->addRow(new Row($content));
            }
            return $this;
        }
        return parent::row($content);
    }

    public function build()
    {
        if($this->renderMode == 'api') {
            $contents = [];
            foreach ($this->rows as $row) {
                $contents = $row->build();
            }
            if(is_array($contents)) {
                return serialize($contents);
            }
            return $contents;
        }
        return parent::build();
    }

    public function render()
    {
        if($this->renderMode == 'api') {
            return $this->build();
        }
        return parent::render();

    }
}
