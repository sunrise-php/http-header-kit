<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAccessControlAllowHeaders;

class HeaderAccessControlAllowHeadersTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo');

        $this->assertSame('Access-Control-Allow-Headers', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo');

        $this->assertSame('x-foo', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo', 'x-bar', 'x-baz');

        $this->assertSame('x-foo, x-bar, x-baz', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Allow-Headers" is not valid');

        new HeaderAccessControlAllowHeaders('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Allow-Headers" is not valid');

        new HeaderAccessControlAllowHeaders('x-foo', '', 'x-bar');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "x-foo=" for the header "Access-Control-Allow-Headers" is not valid');

        // a token cannot contain the "=" character...
        new HeaderAccessControlAllowHeaders('x-foo=');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "x-bar=" for the header "Access-Control-Allow-Headers" is not valid');

        // a token cannot contain the "=" character...
        new HeaderAccessControlAllowHeaders('x-foo', 'x-bar=', 'x-bar');
    }

    public function testBuild()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAccessControlAllowHeaders('x-foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
