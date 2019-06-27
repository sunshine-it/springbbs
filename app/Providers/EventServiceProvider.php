<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// 事件注册控制器
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * $listen 属性里看到注册了 Registered 事件的监听器
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // 事件
        \Illuminate\Auth\Events\Verified::class => [
            // 监听器
            \App\Listeners\EmailVerified::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
