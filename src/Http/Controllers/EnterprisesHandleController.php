<?php

namespace App\Admin\Extensions\Api\Controllers;

use App\Admin\Extensions\Api\HandleController;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class EnterprisesHandleController extends HandleController
{
    public function delete(Request $request): array
    {
        $response = $this->setModelName('App_Models_Enterprises')
            ->setActionName('Encore_Admin_Grid_Actions_Delete')
            ->setInput(true)
            ->boot($request);
        if($response->swal->type == 'success') {
            return $this->success();
        }
        return $this->error();
    }
}
