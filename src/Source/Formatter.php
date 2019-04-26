<?php
namespace ApiFormatter\Source;

class Formatter
{
    protected static $fields = [];

    protected static function item($key, $item, $type, &$info = null)
    {
        switch ($type) {
            case Type::BOOL:
                $item = (bool)$item;
                break;
            case Type::INT:
                $item = (int)$item;
                break;
            case Type::STRING:
                $item = (string)$item;
                break;
            case Type::FLOAT:
                $item = (float)$item;
                break;
            default:
                if (class_exists($type)) {
                    if (is_subclass_of($type, CustomType::class)) {
                        $item = call_user_func($type . '::item', $item);
                    } elseif (is_subclass_of($type, Formatter::class)) {
                        $item = call_user_func($type . '::info', $item);
                    }
                }
                break;
        }
        return $item;
    }

    public static function info($info)
    {
        $result = [];
        if ($info) {
            foreach (static::$fields as $key => $typeOpt) {
                $isOptional = false;
                $isRepeated = false;
                if (is_array($typeOpt)) {
                    $type = isset($typeOpt['type']) ? $typeOpt['type'] : '';
                    if (isset($typeOpt['optional']) && $typeOpt['optional']) {
                        $isOptional = true;
                    }
                    if (isset($typeOpt['repeated']) && $typeOpt['repeated']) {
                        $isRepeated = true;
                    }
                } else {
                    $type = $typeOpt;
                }

                if (isset($info[$key]) || !$isOptional) {
                    $item = isset($info[$key]) ? $info[$key] : ($isRepeated ? [] : '');
                    if ($isRepeated && is_array($item)) {
                        $result[$key] = [];
                        foreach ($item as $_item) {
                            $result[$key][] = static::item($key, $_item, $type, $info);
                        }
                    } else {
                        $result[$key] = static::item($key, $item, $type, $info);
                    }
                }
            }
        }
        return $result ? $result : new \stdClass();
    }

    public static function data($data)
    {
        $result = [];
        if ($data) {
            $std = new \stdClass();
            foreach ($data as $info) {
                $_info = static::info($info);
                if ($_info && !($_info instanceof $std)) {
                    $result[] = $_info;
                }
            }
        }
        return $result;
    }
}