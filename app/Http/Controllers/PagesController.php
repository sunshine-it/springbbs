<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    // root() 方法来处理首页的展示
    public function root() {
        // 首页展示
        return view('pages.root');
    }

    // 无权限提醒页面的控制器方法
    public function permissionDenied() {
        // 如果当前用户有权限访问后台，直接跳转访问
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }
}
