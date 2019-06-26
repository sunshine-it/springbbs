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
}
