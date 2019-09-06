<?php
namespace FormatterTest\DefineType;

use ApiFormatter\DefineType\GenderType;
use PHPUnit\Framework\TestCase;

class GenderTypeTest extends TestCase
{

    public function testItem()
    {
        $this->assertEquals('m', GenderType::item(1));
        $this->assertEquals('f', GenderType::item(2));
        $this->assertEquals('', GenderType::item(0));
    }

}