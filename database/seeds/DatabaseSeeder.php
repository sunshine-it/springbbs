<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 注册用户数据填充
        $this->call(UsersTableSeeder::class);
        // 注册话题数据填充
		$this->call(TopicsTableSeeder::class);
        // 注册帖子回复的数据填充类
        $this->call(ReplysTableSeeder::class);
    }
}
