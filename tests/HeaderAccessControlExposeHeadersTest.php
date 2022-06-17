<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAccessControlExposeHeaders;

class HeaderAccessControlExposeHeadersTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo');

        $this->assertSame('Access-Control-Expose-Headers', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo');

        $this->assertSame('x-foo', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo', 'x-bar', 'x-baz');

        $this->assertSame('x-foo, x-bar, x-baz', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Expose-Headers" is not valid');

        new HeaderAccessControlExposeHeaders('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Expose-Headers" is not valid');

        new HeaderAccessControlExposeHeaders('x-foo', '', 'x-baz');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Access-Control-Expose-Headers" is not valid');

        // isn't a token...
        new HeaderAccessControlExposeHeaders('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Access-Control-Expose-Headers" is not valid');

        // isn't a token...
        new HeaderAccessControlExposeHeaders('x-foo', '@', 'x-baz');
    }

    public function testBuild()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAccessControlExposeHeaders('x-foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
