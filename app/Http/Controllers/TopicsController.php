<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category;
use Auth;
use App\Handlers\ImageUploadHandler; // 图片上传
use App\Models\User;
// 帖子控制器
class TopicsController extends Controller
{
    public function __construct()
    {
        // 对除了 index() 和 show() 以外的方法使用 auth 中间件进行认证
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request, Topic $topic, User $user)
	{
        // 方法 with() 提前加载了我们后面需要用到的关联属性 user 和 category，并做了缓存 | 数据已经被预加载并缓存
        // $topics = Topic::with('user', 'category')->paginate(30);
        // withOrder() 方法来自： springbbs/app/Models/Topic.php
        // $request->order 是获取 URI http://larabbs.test/topics?order=recent 中的 order 参数
		$topics = $topic->withOrder($request->order)->paginate(10);
        $active_users = $user->getActiveUsers();
        // dd($active_users);
		return view('topics.index', compact('topics', 'active_users'));
	}

    public function show(Request $request,Topic $topic)
    {
        // URL 矫正
        // 如果话题的 Slug 字段不为空 并且话题 Slug 不等于请求的路由参数 Slug
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            // 301 永久重定向到正确的 URL 上
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }

	public function create(Topic $topic)
	{
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic', 'categories'));
	}

    // TopicRequest 表单验证类
	public function store(TopicRequest $request, Topic $topic)
	{
        // 获取所有用户的请求数据数组
        $topic->fill($request->all());
        // 获取到的是当前登录的 ID
        $topic->user_id = Auth::id();
        // 保存到数据库中
        $topic->save();
		return redirect()->to($topic->link())->with('success', '帖子创建成功！');
	}

	public function edit(Topic $topic)
	{
        // 授权策略的调用
        $this->authorize('update', $topic);
        $categories = Category::all();
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
        // 授权策略的调用
		$this->authorize('update', $topic);
		$topic->update($request->all());
		return redirect()->to($topic->link())->with('success', '更新成功！');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();
        // 删除了这个回复之后，跳回相关联的话题之下，并带上闪存内容
        return redirect()->to($topic->link())->with('success', '删除成功！');
        // return back()->withInput(['success' => '删除成功！']);
	}

    // 图片上传
    public function uploadImage(Request $request, ImageUploadHandler $uploader) {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
