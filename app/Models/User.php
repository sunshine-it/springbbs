<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Auth;
use Spatie\Permission\Traits\HasRoles; // 加载 HasRoles 用于获取到扩展包提供的所有权限和角色的操作方法

// 用户模型
class User extends Authenticatable implements MustVerifyEmailContract
{
    use Traits\ActiveUserHelper; // 活跃用户

    use HasRoles;

    use MustVerifyEmailTrait;

    use Notifiable {
        notify as protected laravelNotify;
    }
    // 对 notify() 方法做了一个巧妙的重写，现在每当你调用 $user->notify() 时，
    // users 表里的 notification_count 将自动 +1
    public function notify($instance) {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }
        $this->laravelNotify($instance);
    }

    // 清除未读消息标示
    public function markAsRead() {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 用户与话题中间的关系是 一对多 的关系，一个用户拥有多个主题，在 Eloquent 中使用 hasMany() 方法进行关联
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    // isAuthorOf() 方法，只有当话题关联作者的 ID 等于当前登录用户 ID 时候才能操作
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // 一个用户可以拥有多条评论
    public function replies() {
        return $this->hasMany(Reply::class);
    }

    // 使用修改器 对没加密的密码进行 写入数据库前 修改
    public function setPasswordAttribute($value) {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    // 使用修改器 对没头像路径进行 写入数据库前 修改
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 或 `https` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http') || ! starts_with($path, 'https')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }
}
