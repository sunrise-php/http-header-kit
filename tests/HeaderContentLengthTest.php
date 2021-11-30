<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentLength;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentLengthTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentLength(0);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentLength(-1);
    }

    public function testSetLength()
    {
        $header = new HeaderContentLength(0);

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue(1));

        $this->assertSame(1, $header->getValue());
    }

    public function testSetInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentLength(0);

        $header->setValue(-1);
    }

    public function testGetLength()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame(0, $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame('Content-Length', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame('0', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame('Content-Length: 0', (string) $header);
    }
}
