<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

// 计算活跃用户的命令类
class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     * 供调用命令
     * @var string
     */
    protected $signature = 'springbbs:calculate-active-user';

    /**
     * The console command description.
     * 命令的描述
     * @var string
     */
    protected $description = '生成活跃用户';

    /**
     * Execute the console command.
     * 最终执行的方法
     * @return mixed
     */
    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算...");

        $user->calculateAndCacheActiveUsers();

        $this->info("成功生成！");
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
