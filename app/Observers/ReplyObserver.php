<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
// 帖子模型观察|监控器
class ReplyObserver
{
    // 帖子回复成功之后
    public function created(Reply $reply)
    {
        // $reply->topic->increment('reply_count', 1);
        // 统计所有帖子回复|评论
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        // 通知话题作者有新的评论
        // 默认的 User 模型中使用了 trait —— Notifiable，它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    // 使用 HTMLPurifier 来修复此(存在 XSS 安全威胁！)问题。 creating 事件中对 content 字段进行净化处理：
    public function creating(Reply $reply) {
        // 帖子回复之前 自动掉用
        $reply->content = clean($reply->content, 'user_topic_body');
    }
}
