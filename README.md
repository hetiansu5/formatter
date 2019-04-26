## 简述
针对客户端App对API的数据要求强类型，否则容易导致App各种崩溃，而PHP后端本身数据是弱类型的，所以希望有一个方便的数据格式化来cover这个需求。
我们的数据大部分都是从数据库直接取出来，针对每一种数据结构定义一个对应的格式化类，不止提高代码复用，如果有一些敏感字段，也可以很安全的过滤掉，
不会因为遗漏引发安全问题。
比如user数据表，从数据库直接拿出来，如果遗漏掉过滤password直接输出到API，也是一件很可怕的事情。

## 应用场景
数据格式化

## 依赖要求
+ PHP >= 5.6

## 目录说明
```
|- src 
    |- Source 项目最基础的源码
    |- DefineType 自定义的数据类型，使用demo，后期根据业务需要，定义到自己的项目代码目录中
    |- DefineFormatter 自定义的数据格式化类，使用demo，后期根据业务需要，定义到自己的项目代码目录中
|- example
    |- test.php 使用案例
```    
    
## 案例

```
如果直接使用本项目测试的话，需要先运行一下composer install
直接命令行直接代码：php example/test.php
```

## 代码示例

```
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
```    

