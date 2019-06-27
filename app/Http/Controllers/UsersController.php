<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest; // 表单请求验证
use App\Handlers\ImageUploadHandler; // 图片上传处理器
// 用户控制器
class UsersController extends Controller
{
    // 中间件 (middleware)
    public function __construct() {
        // 通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，除了此处指定的动作以外，所有其他动作都必须登录用户才能访问
        $this->middleware('auth', ['except' => ['show']]);
    }

    // show 方法来处理个人页面的展示
    public function show(User $user) {
        // 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将变量数据传递到视图中
        return view('users.show', compact('user'));
    }
    // edit 方法编辑个人资料页面的展示
    public function edit(User $user)
    {
        // authorize 方法来检验用户是否授权
        $this->authorize('update', $user); // 第一个为授权策略的名称，第二个为进行授权验证的数据。
        return view('users.edit', compact('user'));
    }
    // update 方法来处理 edit 页面提交的更改
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        // authorize 方法来检验用户是否授权
        $this->authorize('update', $user); // 第一个为授权策略的名称，第二个为进行授权验证的数据。
        $data = $request->all();
        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            } else {
                //上传有错误  withErrors可以携带回错误信
                return back()->withErrors(['上传头像必须是 jpeg, bmp, png, gif 格式的图片']);
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
