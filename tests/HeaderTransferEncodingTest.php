<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderTransferEncoding;

class HeaderTransferEncodingTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderTransferEncoding('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderTransferEncoding('foo');

        $this->assertSame('Transfer-Encoding', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderTransferEncoding('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderTransferEncoding('foo', 'bar', 'baz');

        $this->assertSame('foo, bar, baz', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Transfer-Encoding" is not valid');

        new HeaderTransferEncoding('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Transfer-Encoding" is not valid');

        new HeaderTransferEncoding('foo', '', 'baz');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Transfer-Encoding" is not valid');

        // isn't a token...
        new HeaderTransferEncoding('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Transfer-Encoding" is not valid');

        // isn't a token...
        new HeaderTransferEncoding('foo', '@', 'baz');
    }

    public function testBuild()
    {
        $header = new HeaderTransferEncoding('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderTransferEncoding('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
