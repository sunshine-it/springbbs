<?php

// 用于后台管理话题模型
if (! function_exists('model_admin_link') || ! function_exists('model_link')  || ! function_exists('model_plural_name')) {

    function model_admin_link($title, $model) {
        return model_link($title, $model, 'admin');
    }

    function model_link($title, $model, $prefix = '') {
        // 获取数据模型的复数蛇形命名
        $model_name = model_plural_name($model);

        // 初始化前缀
        $prefix = $prefix ? "/$prefix/" : '/';

        // 使用站点 URL 拼接全量 URL
        $url = config('app.url') . $prefix . $model_name . '/' . $model->id;

        // 拼接 HTML A 标签，并返回
        return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
    }

    function model_plural_name($model)
    {
        // 从实体中获取完整类名，例如：App\Models\User
        $full_class_name = get_class($model);

        // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
        $class_name = class_basename($full_class_name);

        // 蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
        $snake_case_name = snake_case($class_name);

        // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
        return str_plural($snake_case_name);
    }
}

// 监听数据处理
if (! function_exists('make_excerpt')) {
    function make_excerpt($value, $length = 200)
    {
        $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
        return str_limit($excerpt, $length);
    }
}

// Bootstrap 框架的 导航栏组件  hieu-le/active
if (! function_exists('category_nav_active')) {
    function category_nav_active($category_id)
    {
        // if_route () - 判断当前对应的路由是否是指定的路由
        // if_route_param () - 判断当前的 url 有无指定的路由参数
        return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
    }
}

// 此方法会将当前请求的路由名称转换为 CSS 类名称
if (! function_exists('route_class')) {
    // 作用是允许针对某个页面做页面样式定制
    function route_class() {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

// 为不同环境的数据库连接方式定义一个帮助方法
if (! function_exists('get_db_config')) {
    function get_db_config() {
        if (getenv('IS_IN_HEROKU')) {
            $url = parse_url(getenv("DATABASE_URL"));
            return $db_config = [
                'connection' => 'pgsql',
                'host' => $url["host"],
                'database'  => substr($url["path"], 1),
                'username'  => $url["user"],
                'password'  => $url["pass"],
            ];
        } else {
            return $db_config = [
                'connection' => env('DB_CONNECTION', 'mysql'),
                'host' => env('DB_HOST', 'localhost'),
                'database'  => env('DB_DATABASE', 'forge'),
                'username'  => env('DB_USERNAME', 'forge'),
                'password'  => env('DB_PASSWORD', ''),
            ];
        }
    }
}
