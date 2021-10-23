<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentRange;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentRangeTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidFirstBytePosition()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentRange(2, 1, 2);
    }

    public function testConstructorWithInvalidLastBytePosition()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentRange(0, 2, 2);
    }

    public function testConstructorWithInvalidInstanceLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentRange(0, 1, 1);
    }

    public function testSetRange()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertInstanceOf(HeaderInterface::class, $header->setRange(3, 4, 5));

        $this->assertEquals(3, $header->getFirstBytePosition());

        $this->assertEquals(4, $header->getLastBytePosition());

        $this->assertEquals(5, $header->getInstanceLength());
    }

    public function testGetFirstBytePosition()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals(0, $header->getFirstBytePosition());
    }

    public function testGetLastBytePosition()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals(1, $header->getLastBytePosition());
    }

    public function testGetInstanceLength()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals(2, $header->getInstanceLength());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals('Content-Range', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals('bytes 0-1/2', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertEquals('Content-Range: bytes 0-1/2', (string) $header);
    }
}
