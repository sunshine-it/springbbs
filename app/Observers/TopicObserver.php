<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
// 帖子模型观察器
class TopicObserver
{
    // 监听数据即将保存的事件
    public function saving(Topic $topic)
    {
        // 在数据入库前进行 XSS 过滤 (配置 HTMLPurifier for Laravel 5)
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

}
