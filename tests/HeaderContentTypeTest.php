<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentType;

class HeaderContentTypeTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentType('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentType('foo');

        $this->assertSame('Content-Type', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentType('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $header = new HeaderContentType('foo', [
            'bar' => '',
        ]);

        $this->assertSame('foo; bar=""', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $header = new HeaderContentType('foo', [
            'bar' => 'token',
        ]);

        $this->assertSame('foo; bar="token"', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $header = new HeaderContentType('foo', [
            'bar' => 'quoted string',
        ]);

        $this->assertSame('foo; bar="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderContentType('foo', [
            'bar' => 1,
        ]);

        $this->assertSame('foo; bar="1"', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderContentType('foo', [
            'bar' => '',
            'baz' => 'token',
            'bat' => 'quoted string',
            'qux' => 1,
        ]);

        $this->assertSame('foo; bar=""; baz="token"; bat="quoted string"; qux="1"', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Content-Type" is not valid');

        new HeaderContentType('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Content-Type" is not valid');

        // isn't a token...
        new HeaderContentType('@');
    }

    public function testInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "invalid name" for the header "Content-Type" is not valid'
        );

        // cannot contain spaces...
        new HeaderContentType('foo', ['invalid name' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Content-Type" is not valid'
        );

        // cannot contain spaces...
        new HeaderContentType('foo', [0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "Content-Type" is not valid'
        );

        // cannot contain quotes...
        new HeaderContentType('foo', ['name' => '"invalid value"']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Content-Type" is not valid'
        );

        // cannot contain quotes...
        new HeaderContentType('foo', ['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderContentType('foo', ['bar' => 'baz']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentType('foo', ['bar' => 'baz']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
