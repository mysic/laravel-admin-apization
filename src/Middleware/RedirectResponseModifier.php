<?php

namespace Mysic\LaravelAdminApization\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;
use Mysic\LaravelAdminApization\ResponseMessage;


class RedirectResponseModifier
{
    use ResponseMessage;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response instanceof RedirectResponse) {
            /** @var ViewErrorBag $errors */
            $errors = $response->getSession()->all()['errors'] ?? null;
            if($errors && $errors->isNotEmpty()) {
                $errMsg = Arr::flatten(array_values($errors->getMessages()));
                return new Response($this->error([],implode(',',$errMsg)));
            }
            return  new Response($this->success());
        }
        elseif($response instanceof Response) {
            if(!empty($response->exception)) {
                Log::error($response->exception);
                return new Response($this->error([],'操作错误，请稍后再试'));
            }
            try {
                $data = unserialize($response->getContent());
            }catch(\Throwable $t) {
                Log::error($t->getMessage());
                return new Response($this->error([],'此页面未找到' . $t->getMessage()));
            }
            return new Response($this->success($data));
        }
        elseif($response instanceof JsonResponse) {
            $data = json_decode($response->getContent(), true);
            if(!key_exists('code', $data) && !key_exists('msg', $data)) {
                return new Response($this->success($data));
            }
            if($data['code'] == 'success') {
                return new Response($this->success($data['data'], $data['msg']));
            }
            return new Response($this->error($data['data'],$data['msg']));
        }
        return  New Response($this->success());

    }
}
