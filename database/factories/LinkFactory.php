<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */
// use Faker\Generator as Faker;
$faker = Faker\Factory::create('zh_CN');
// 边栏的资源推荐 的工厂模型
$factory->define(App\Models\Link::class, function() use ($faker) {
    return [
        'title' => $faker->name,
        'link' => $faker->url,
    ];
});
