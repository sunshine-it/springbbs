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
        $topic->excerpt = make_excerpt($topic->body);
    }

}
