<?php

use App\Http\Middleware\VerifyCsrfToken;
use Mysic\LaravelAdminApization\Http\Controllers\PermissionController;
use Mysic\LaravelAdminApization\Http\Controllers\PermissionHandleController;
use Mysic\LaravelAdminApization\Http\Controllers\RoleController;
use Mysic\LaravelAdminApization\Http\Controllers\RoleHandleController;
use Mysic\LaravelAdminApization\Http\Controllers\UsersController;
use Mysic\LaravelAdminApization\Http\Controllers\UsersHandleController;
use Mysic\LaravelAdminApization\Middleware\VerifyCsrfToken as MysicVerifyCsrfToken;
use Mysic\LaravelAdminApization\Middleware\Authenticate;
use Mysic\LaravelAdminApization\Middleware\RedirectResponseModifier;
use Illuminate\Routing\Router;

return [
    'middlewares' => [
        'replacements' => [
            'admin.auth' => Authenticate::class,
            VerifyCsrfToken::class => MysicVerifyCsrfToken::class,
            'admin.response' => RedirectResponseModifier::class,
        ],
        'groups' => [
            'admin' => [
                'admin.response'
            ]
        ],
    ],
    'router' => [
        'attributes' => [
            'prefix' => config('admin.route.prefix'),
            'middleware' => config('admin.route.middleware')
        ],
        'replacements' => function (Router $router) {
            $router->post('/auth/users/delete',[UsersHandleController::class, 'delete']);
            $router->post('/auth/roles/delete', [RoleHandleController::class, 'delete']);
            $router->post('/auth/permissions/delete', [PermissionHandleController::class, 'delete']);
            $router->get('/auth/users', [UsersController::class, 'index']);
            $router->get('/auth/roles', [RoleController::class, 'index']);
            $router->get('/auth/permissions', [PermissionController::class, 'index']);
        },
        'blacklist' => [
            'auth/login',
        ],
        'response' => [
            'blacklist' => ['code' => 'error', 'msg' => '访问的页面不存在']
        ]
    ],
    'auth' => [
        'guard' => 'admin'
    ],


];
