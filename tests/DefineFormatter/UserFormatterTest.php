<?php
namespace ApiFormatter\DefineFormatter;

use ApiFormatter\DefineType\DateType;
use ApiFormatter\DefineType\GenderType;
use ApiFormatter\Source\Formatter;
use ApiFormatter\Source\Type;
use PHPUnit\Framework\TestCase;

class UserFormatterTest extends TestCase
{

    private $info = [
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

    public function testInfo()
    {
        $info = $this->info;
        $info['share'] = [
            'qq' => '110'
        ];
        $info['fee'] = '11.2';
        $t = UserFormatter::info($info);
        $this->assertEquals([
            'id' => (int)$info['id'],
            'screen_name' => $info['screen_name'],
            'avatar' => $info['avatar'],
            'gender' => 'm',
            'created_at' => date('Y-m-d H:i:s', $info['created_at']),
            'amount' => round($info['total_amount'] / 100, 2),
            'is_vip' => true,
            'tags' => [1, 2, 3],
            'fee' => (float)'11.2',
            'share' => [
                'qq' => '110'
            ],
        ], $t);
    }

    public function testData()
    {
        $info = $this->info;
        $t = UserFormatter::data([$info]);
        $this->assertEquals([[
            'id' => (int)$info['id'],
            'screen_name' => $info['screen_name'],
            'avatar' => $info['avatar'],
            'gender' => 'm',
            'created_at' => date('Y-m-d H:i:s', $info['created_at']),
            'amount' => round($info['total_amount'] / 100, 2),
            'is_vip' => true,
            'tags' => [1, 2, 3],
            'fee' => 0.0
        ]], $t);
    }

}

/**
 * 用户数据结构格式化
 * demo
 */
class UserFormatter extends Formatter
{

    /**
     * 定义各个字段最终格式化的数据结构
     *
     * @var array
     */
    protected static $fields = [
        'id' => Type::INT,
        'screen_name' => Type::STRING, //昵称
        'avatar' => Type::STRING, //头像
        'gender' => GenderType::class, //自定义的数据类型
        'created_at' => DateType::class, //注册时间
        'amount' => Type::FLOAT, //账户余额
        'fee' => Type::FLOAT, //费用
        'is_vip' => Type::BOOL, //是否VIP
        'fans_count' => [
            'type' => Type::INT,
            'optional' => true, //标识此字段为可选，只要当数据中存在此字段，格式化后才会有
        ],
        'tags' => [ //用户有多个兴趣标签
            'type' => Type::STRING,
            'repeated' => true, //是否多个
        ],
        'share' => [ //社交平台
            'type' => ShareFormatter::class,
            'optional' => true,
        ]
    ];

    /**
     * 此函数可以对字段值做自定义处理 [可选]
     *
     * @param $key
     * @param $item
     * @param $type
     * @param null $info
     * @return bool|float|int|mixed|string
     */
    protected static function item($key, $item, $type, &$info = null)
    {
        if ($key == 'amount') {
            $item = round($info['total_amount'] / 100, 2);
        } else {
            $item = parent::item($key, $item, $type, $info);
        }
        return $item;
    }

}


class ShareFormatter extends Formatter
{
    protected static $fields = [
        'qq' => Type::STRING,
    ];

}

