<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderKeepAlive;

class HeaderKeepAliveTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderKeepAlive();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderKeepAlive();

        $this->assertSame('Keep-Alive', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderKeepAlive();

        $this->assertSame('', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $header = new HeaderKeepAlive([
            'foo' => '',
        ]);

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $header = new HeaderKeepAlive([
            'foo' => 'token',
        ]);

        $this->assertSame('foo=token', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $header = new HeaderKeepAlive([
            'foo' => 'quoted string',
        ]);

        $this->assertSame('foo="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderKeepAlive([
            'foo' => 1,
        ]);

        $this->assertSame('foo=1', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderKeepAlive([
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
            'The parameter-name "invalid name" for the header "Keep-Alive" is not valid'
        );

        // cannot contain spaces...
        new HeaderKeepAlive(['invalid name' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Keep-Alive" is not valid'
        );

        new HeaderKeepAlive([0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "Keep-Alive" is not valid'
        );

        // cannot contain quotes...
        new HeaderKeepAlive(['name' => '"invalid value"']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Keep-Alive" is not valid'
        );

        new HeaderKeepAlive(['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderKeepAlive(['foo' => 'bar']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderKeepAlive(['foo' => 'bar']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
