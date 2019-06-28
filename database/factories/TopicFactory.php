<?php

// use Faker\Generator as Faker;

$faker = Faker\Factory::create('zh_CN');
// 话题的数据工厂
$factory->define(App\Models\Topic::class, function () use ($faker) {
    $sentence = $faker->companyPrefix();
    $sentence_x = $faker->companySuffix();
    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();
    // 传参为生成最大时间不超过，因为创建时间需永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'title' => $sentence,
        'body' => $faker->catchPhrase(),
        'excerpt' => $sentence_x,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
