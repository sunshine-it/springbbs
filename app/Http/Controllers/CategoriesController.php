<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
// 分类列表话题
class CategoriesController extends Controller
{
    // 分类话题列表排序
    public function show(Category $category, Request $request, Topic $topic, User $user) {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        // $topics = Topic::with('user', 'category')->where('category_id', $category->id)->paginate(20);
        // withOrder() 方法来自： springbbs/app/Models/Topic.php
        $topics = $topic->withOrder($request->order)->where('category_id', $category->id)->paginate(20);
        // 活跃用户列表
        $active_users = $user->getActiveUsers();
        // 传参变量话题和分类到模板中
        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
