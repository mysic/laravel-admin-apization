<?php

namespace Mysic\LaravelAdminApization\Middleware;

use Mysic\LaravelAdminApization\ResponseMessage;
use Closure;
use Encore\Admin\Facades\Admin;

class Authenticate extends \Encore\Admin\Middleware\Authenticate
{
    use ResponseMessage;

    public function handle($request, Closure $next)
    {
        if (Admin::guard()->guest() && !$this->shouldPassThrough($request)) {
            return response($this->error([], '未登录，请先登录'));
        }
        return $next($request);
    }
}
