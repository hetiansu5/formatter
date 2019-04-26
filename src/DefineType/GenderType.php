<?php
namespace ApiFormatter\DefineType;

use ApiFormatter\Source\CustomType;

/**
 * 自定义数据类型：性别
 * demo
 */
class GenderType implements CustomType
{

    public static function item($item)
    {
        if ($item == 1) {
            $item = 'm';
        } elseif ($item == 2) {
            $item = 'f';
        } else {
            $item = '';
        }
        return $item;
    }

}