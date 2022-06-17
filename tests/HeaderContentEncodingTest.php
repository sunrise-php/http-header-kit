<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentEncoding;

class HeaderContentEncodingTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentEncoding('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentEncoding('foo');

        $this->assertSame('Content-Encoding', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentEncoding('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Content-Encoding" is not valid');

        new HeaderContentEncoding('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Content-Encoding" is not valid');

        // isn't a token...
        new HeaderContentEncoding('@');
    }

    public function testBuild()
    {
        $header = new HeaderContentEncoding('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentEncoding('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
