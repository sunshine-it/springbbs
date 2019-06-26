<?php

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
