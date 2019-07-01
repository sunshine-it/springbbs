<?php
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
