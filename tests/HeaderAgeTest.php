<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAge;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAgeTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAge(0);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAge(-1);
    }

    public function testSetValue()
    {
        $header = new HeaderAge(0);

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue(1));

        $this->assertEquals(1, $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAge(0);

        $header->setValue(-1);
    }

    public function testGetValue()
    {
        $header = new HeaderAge(0);

        $this->assertEquals(0, $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAge(0);

        $this->assertEquals('Age', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAge(0);

        $this->assertEquals('0', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderAge(0);

        $this->assertEquals('Age: 0', (string) $header);
    }
}
