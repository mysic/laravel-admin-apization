<?php

namespace Mysic\LaravelAdminApization\Middleware;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;
use App\Http\Middleware\VerifyCsrfToken as ParentVerifyCsrfToken;

class VerifyCsrfToken extends ParentVerifyCsrfToken
{
    protected $addHttpCookie = false;
    protected $except = [];

    //tips 后端nginx设置同源策略，请求接口只允许前端服务器所在的IP来进行CSRF防御
    public function __construct(Application $app, Encrypter $encrypter)
    {
        parent::__construct($app, $encrypter);
        /** @var Router $router */
        $router = app('router');
        $this->except = array_column($router->getRoutes()->getRoutes(),'uri');
    }

    protected function tokensMatch($request): bool
    {
        return true;
    }

}
