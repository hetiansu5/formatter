<?php

use ApiFormatter\DefineFormatter\UserFormatter;

require __DIR__  . '/../vendor/autoload.php';

$info = [
    'id' => '11',
    'screen_name' => '我是谁', //昵称
    'avatar' => '1.jpg', //头像
    'gender' => 1, //自定义的数据类型
    'created_at' => 1520001111, //注册时间
    'total_amount' => '1123', //账户余额
    'is_vip' => 1, //是否VIP
    'tags' => [1, 2, 3], //标签
    'none' => false, //无用字段
];
//针对单item进行数据格式化
$t = UserFormatter::info($info);
var_dump($t);

$data = [
    $info,
    $info
];
//针对列表进行数据格式化
$t = UserFormatter::data($data);
var_dump($t);