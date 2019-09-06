<?php
namespace FormatterTest\DefineType;

use ApiFormatter\DefineType\DateType;
use PHPUnit\Framework\TestCase;

class DateTypeTest extends TestCase
{

    public function testItem()
    {
        $item = 150001111;
        $this->assertEquals(date('Y-m-d H:i:s', $item), DateType::item($item));
    }

}