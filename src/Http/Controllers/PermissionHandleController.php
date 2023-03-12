<?php

namespace Mysic\LaravelAdminApization\Http\Controllers;

use Mysic\LaravelAdminApization\HandleController;
use Illuminate\Http\Request;

class PermissionHandleController extends HandleController
{
    public function delete(Request $request): array
    {
        $response = $this->setModelName('Encore_Admin_Auth_Database_Permission')
            ->setActionName('Encore_Admin_Grid_Actions_Delete')
            ->setInput(true)
            ->run($request);
        if($response->swal->type == 'success') {
            return $this->success();
        }
        return $this->error();
    }
}
