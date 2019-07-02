<?php

// use Faker\Generator as Faker;
$faker = Faker\Factory::create('zh_CN');
// 帖子回复的定制数据工厂
$factory->define(App\Models\Reply::class, function() use ($faker) {
    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();
    return [
        'content' => $faker->catchPhrase(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
