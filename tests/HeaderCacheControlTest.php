<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderCacheControl;

class HeaderCacheControlTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderCacheControl([]);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderCacheControl([]);

        $this->assertSame('Cache-Control', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderCacheControl([]);

        $this->assertSame('', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $header = new HeaderCacheControl([
            'foo' => '',
        ]);

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $header = new HeaderCacheControl([
            'foo' => 'token',
        ]);

        $this->assertSame('foo=token', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $header = new HeaderCacheControl([
            'foo' => 'quoted string',
        ]);

        $this->assertSame('foo="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderCacheControl([
            'foo' => 1,
        ]);

        $this->assertSame('foo=1', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderCacheControl([
            'foo' => '',
            'bar' => 'token',
            'baz' => 'quoted string',
            'qux' => 1,
        ]);

        $this->assertSame('foo, bar=token, baz="quoted string", qux=1', $header->getFieldValue());
    }

    public function testInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "invalid name" for the header "Cache-Control" is not valid'
        );

        new HeaderCacheControl(['invalid name' => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "Cache-Control" is not valid'
        );

        new HeaderCacheControl(['name' => '"invalid value"']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Cache-Control" is not valid'
        );

        new HeaderCacheControl([0 => 'value']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Cache-Control" is not valid'
        );

        new HeaderCacheControl(['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderCacheControl(['foo' => 'bar']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderCacheControl(['foo' => 'bar']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
