<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest; // 表单请求验证
// 用户控制器
class UsersController extends Controller
{
    // show 方法来处理个人页面的展示
    public function show(User $user) {
        // 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将变量数据传递到视图中
        return view('users.show', compact('user'));
    }
    // edit 方法编辑个人资料页面的展示
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    // update 方法来处理 edit 页面提交的更改
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
