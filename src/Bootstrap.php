<?php
declare(strict_types=1);

namespace Mysic\LaravelAdminApization;


use Illuminate\Routing\Router;

class Bootstrap
{
    /** @var Router */
    protected static $router;

    protected static $routeAttributes = [];
    protected static $routeMiddleware = [];
    protected static $routeBlackList = [];
    protected static $routeBlacklistResponse = [];
    protected static $routeReplacementsClosure;
    protected static $pushToMiddlewareGroup = [];

    public static function boot()
    {
        self::$routeAttributes = config('apization.router.attributes',[]);
        self::$routeMiddleware = config('apization.middlewares.replacements',[]);
        self::$routeBlackList = config('apization.router.blacklist',[]);
        self::$routeReplacementsClosure = config('apization.router.replacements',function(){});
        self::$pushToMiddlewareGroup = config('apization.middlewares.groups',[]);
        self::$routeBlacklistResponse = config('apization.router.response.blacklist',[]);

        self::$router = app('router');
        self::disableRoutes();
        self::replaceRoutes();
        self::replaceRouteMiddleware();
        self::setAuthDefaultGuard();
        self::middlewareGroupPush();
    }

    protected static function disableRoutes()
    {
        if(!empty(self::$routeBlackList)) {
            self::$router->group(self::$routeAttributes, function (Router $router) {
                foreach(self::$routeBlackList as $uri) {
                    $router->get($uri, function(){
                        exit(json_encode(self::$routeBlacklistResponse));
                    });
                }
            });
        }
    }

    //todo 将用户自定义的路由通过程序的方式自动遍历
    protected static function replaceRoutes()
    {
        self::$router->group(self::$routeAttributes, self::$routeReplacementsClosure);
    }

    protected static function middlewareGroupPush()
    {
        if(!empty(self::$pushToMiddlewareGroup)) {
            foreach(self::$pushToMiddlewareGroup as $groupName => $list) {
                $adminGroup = self::$router->getMiddlewareGroups()[$groupName] ?? null;
                if(!$adminGroup) {
                    continue;
                }
                array_push($adminGroup, $list);
                self::$router->middlewareGroup($groupName, $adminGroup);
            }
        }
    }

    protected static function replaceRouteMiddleware()
    {
        foreach(self::$routeMiddleware as $key => $val) {
            self::$router->aliasMiddleware($key, $val);
        }
    }

    protected static function setAuthDefaultGuard()
    {
        config(['auth.defaults.guard' => config('apization.auth.guard')]);
    }

}
