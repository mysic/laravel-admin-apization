<?php

namespace Mysic\LaravelAdminApization;

use Closure;
use Encore\Admin\Grid\Column;
use App\Admin\Extensions\Api\Grid\Tools\Paginator;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Pagination\LengthAwarePaginator;

class Grid extends \Encore\Admin\Grid
{
    protected $renderMode;
    public function __construct(Eloquent $model, Closure $builder = null)
    {
        $this->renderMode = env('ADMIN_RENDER_MODE', 'ssr');
        parent::__construct($model, $builder);
    }

    public function build()
    {
        if($this->renderMode == 'api') {
            if ($this->builded) {
                return;
            }
            $this->applyQuery();
            $collection = $this->applyFilter(false);
            Column::setOriginalGridModels($collection);
            $data = $collection->toArray();

            $newData = [];
            foreach($data as $key => $item) {
                $newData[$key] = [];
                $this->columns->map(function(Column $column) use ($item, $key, &$newData) {
                    if(key_exists($column->getName(),$item)) {
                        $newData[$key][$column->getName()] = $item[$column->getName()];
                    }
                });
            }

            /** @var LengthAwarePaginator $paginator */
            $paginator = $this->paginator()->paginator;

            return [
                'total_data' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_page' => $paginator->lastPage(),
                'data' => $newData
            ];
        }
        parent::build();
    }

    public function paginator($perPage = 20): Paginator
    {
        return new Paginator($this, $this->options['show_perpage_selector']);
    }

    public function render()
    {
        if($this->renderMode == 'api') {
            return $this->build();
        }

        return parent::render();
    }
}
