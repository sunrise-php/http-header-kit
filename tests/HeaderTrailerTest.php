<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderTrailer;
use Sunrise\Http\Header\HeaderInterface;

class HeaderTrailerTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderTrailer('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderTrailer('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderTrailer('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('new-value'));

        $this->assertSame('new-value', $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderTrailer('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderTrailer('value');

        $this->assertSame('value', $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderTrailer('value');

        $this->assertSame('Trailer', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderTrailer('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderTrailer('value');

        $this->assertSame('Trailer: value', (string) $header);
    }
}
