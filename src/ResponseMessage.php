<?php

namespace Mysic\LaravelAdminApization;


//tips 统一接口响应的格式
//      创建自定义Controller基类 \App\Http\Controllers\Controller 继承 \Illuminate\Routing\Controller
//      \App\Http\Controllers\Controller 内use此trait
trait ResponseMessage
{
    public function success($data = [], $messages = '操作成功', $code = 'success'): array
    {
        return ['code' => $code, 'msg' => $messages, 'data' => $data];
    }
    public function error($data = [], $messages = '操作失败', $code = 'error'): array
    {
        return ['code' => $code, 'msg' => $messages, 'data' => $data];
    }
}
