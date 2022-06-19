<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentLength;

class HeaderContentLengthTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentLength(0);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame('Content-Length', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentLength(0);

        $this->assertSame('0', $header->getFieldValue());
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "-1" for the header "Content-Length" is not valid');

        new HeaderContentLength(-1);
    }

    public function testBuild()
    {
        $header = new HeaderContentLength(0);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentLength(0);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
