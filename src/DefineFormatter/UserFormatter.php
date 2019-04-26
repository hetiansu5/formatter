<?php
namespace ApiFormatter\DefineFormatter;

use ApiFormatter\DefineType\DateType;
use ApiFormatter\DefineType\GenderType;
use ApiFormatter\Source\Formatter;
use ApiFormatter\Source\Type;

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
        'is_vip' => Type::BOOL, //是否VIP
        'fans_count' => [
            'type' => Type::INT,
            'optional' => true, //标识此字段为可选，只要当数据中存在此字段，格式化后才会有
        ],
        'tags' => [ //用户有多个兴趣标签
            'type' => Type::STRING,
            'repeated' => true, //是否多个
        ],
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
