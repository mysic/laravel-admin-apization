<?php

namespace Mysic\LaravelAdminApization\Layout;


class Row extends \Encore\Admin\Layout\Row
{
    protected $renderMode;

    public function __construct($content = '')
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($content);
    }

    public function column($width, $content)
    {
        if($this->renderMode == 'api') {
            $column = new Column($content, $width);
            $this->columnAdd($column);
            return;
        }
        parent::column($width, $content);

    }

    /**
     * @param Column $column
     */
    protected function columnAdd(Column $column)
    {
        $this->columns[] = $column;
    }

    public function build()
    {
        if($this->renderMode == 'api') {
            $data = [];
            foreach ($this->columns as $column) {
                $data = $column->build();
            }
            return $data;
        }
        parent::build();
    }
}
