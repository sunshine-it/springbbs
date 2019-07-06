<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

// 边栏推荐模型观察 | 监控器
class LinkObserver
{
    // 在保存成功之后清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        Cache::forget($link->cache_key);
    }
}
