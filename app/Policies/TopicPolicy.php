<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        // update() 方法进行修改，只有当话题关联作者的 ID 等于当前登录用户 ID 时候才能修改
        // return $topic->user_id == $user->id;
        // return true;
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        // 只允许作者删除话题
        // return $topic->user_id == $user->id;
        // return true;
        return $user->isAuthorOf($topic);
    }
}
