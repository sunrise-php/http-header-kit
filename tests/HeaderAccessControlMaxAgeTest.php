<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlMaxAge;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlMaxAgeTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlMaxAge(0);
    }

    public function testSetValue()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue(-1));

        $this->assertEquals(-1, $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlMaxAge(86400);

        $header->setValue(0);
    }

    public function testGetValue()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertEquals(86400, $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertEquals('Access-Control-Max-Age', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertEquals('86400', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderAccessControlMaxAge(86400);

        $this->assertEquals('Access-Control-Max-Age: 86400', (string) $header);
    }
}
