<?php

namespace App\Observers;

use App\Models\Topic;
// 队列执行 帖子模型观察|监控器
use App\Jobs\TranslateSlug;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored
// 帖子模型观察器
class TopicObserver
{
    // 监听数据即将保存的事件 此事件发生在创建和编辑时、数据入库之前
    public function saving(Topic $topic)
    {
        // XSS 过滤 (配置 HTMLPurifier for Laravel 5)
        $topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    // 监听处理完成后的操作 此事件发生在创建和编辑时、数据入库以后
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    // 当话题被删除的时候，将监听话题删除成功的事件，在此事件发生时，删除此话题下所有的回复
    public function deleted(Topic $topic) {
       \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}
