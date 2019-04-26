<?php
namespace ApiFormatter\DefineType;

use ApiFormatter\Source\CustomType;

/**
 * 自定义数据类型：日期 yyyy-mm-dd HH:ii:ss
 * demo
 */
class DateType implements CustomType
{

    public static function item($item)
    {
        return date('Y-m-d H:i:s', $item);
    }

}