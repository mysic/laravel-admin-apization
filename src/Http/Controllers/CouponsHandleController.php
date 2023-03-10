<?php

namespace Mysic\LaravelAdminApization\Http\Controllers;

use Mysic\LaravelAdminApization\HandleController;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class CouponsHandleController extends HandleController
{
    public function delete(Request $request): array
    {
        $response = $this->setModelName('App_Models_Coupons')
            ->setActionName('Encore_Admin_Grid_Actions_Delete')
            ->setInput(true)
            ->boot($request);
        if($response->swal->type == 'success') {
            return $this->success();
        }
        return $this->error();
    }
}
