<?php

namespace App\Admin\Extensions\Api\Controllers;


use App\Traits\ResponseMessage;
use Encore\Admin\Controllers\Dashboard;
use Illuminate\Http\Request;

/**
 * @deprecated
 */
class DashboardController extends Dashboard
{
    use ResponseMessage;

    public function index(Request $request): array
    {
        return $this->success($request->user()->id);
    }
}
