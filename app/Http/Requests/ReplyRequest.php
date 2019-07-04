<?php

namespace App\Http\Requests;
// 回复|评论验证类
class ReplyRequest extends Request
{
    public function rules()
    {
        // 回复至少有两个字符的长度
        return [
            'content' => 'required|min:2',
        ];
    }

    public function messages()
    {
        return [
            'content.min' => '回复内容必须至少两个字符',
        ];
    }
}
