<?php

namespace Mysic\LaravelAdminApization;

use Illuminate\Http\Request;

class HandleController extends \Encore\Admin\Controllers\HandleController
{
    use ResponseMessage;

    protected $model;
    protected $action;
    protected $input;

    protected function run(Request $request)
    {
        $payLoad = [
            '_key' => $request->post('id'),
            '_model' => $this->model,
            '_action' => $this->action,
            '_input' => $this->input
        ];
        $newRequest = Request::create(
            $request->getUri(),
            'POST',
            $payLoad,
            $request->cookie(),
            $request->file(),
            $request->server(),
            $request->getContent()
        );
        $response = parent::handleAction($newRequest);
        return $response->getData();
    }

    protected function setModelName($modelName): HandleController
    {
        $this->model = $modelName;
        return $this;
    }

    protected function setActionName($actionName): HandleController
    {
        $this->action = $actionName;
        return $this;
    }

    protected function setInput($inputName): HandleController
    {
        $this->input = $inputName;
        return $this;
    }

}
