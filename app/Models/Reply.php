<?php

namespace App\Models;

class Reply extends Model
{
    // 只允许用户更改 content 字段
    protected $fillable = ['content'];

    // 一条回复属于一个话题
    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    // 一个条回复属于一个作者所有
    public function user() {
        return $this->belongsTo(User::class);
    }
}
