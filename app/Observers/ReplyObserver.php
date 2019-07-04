<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
// 帖子模型观察|监控器
class ReplyObserver
{
    // 帖子回复成功之后
    public function created(Reply $reply)
    {
        // $reply->topic->increment('reply_count', 1);
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }

    // 使用 HTMLPurifier 来修复此(存在 XSS 安全威胁！)问题。 creating 事件中对 content 字段进行净化处理：
    public function creating(Reply $reply) {
        // 帖子回复之前 自动掉用
        $reply->content = clean($reply->content, 'user_topic_body');
    }
}
