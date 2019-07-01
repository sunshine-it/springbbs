<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\SlugTranslateHandler; // 使用 Guzzle 及 拼音

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
        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }

}
