<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentDisposition;

class HeaderContentDispositionTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentDisposition('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentDisposition('foo');

        $this->assertSame('Content-Disposition', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentDisposition('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $header = new HeaderContentDisposition('foo', [
            'bar' => '',
        ]);

        $this->assertSame('foo; bar=""', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $header = new HeaderContentDisposition('foo', [
            'bar' => 'token',
        ]);

        $this->assertSame('foo; bar="token"', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $header = new HeaderContentDisposition('foo', [
            'bar' => 'quoted string',
        ]);

        $this->assertSame('foo; bar="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderContentDisposition('foo', [
            'bar' => 1,
        ]);

        $this->assertSame('foo; bar="1"', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderContentDisposition('foo', [
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
        $this->expectExceptionMessage('The value "" for the header "Content-Disposition" is not valid');

        new HeaderContentDisposition('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Content-Disposition" is not valid');

        // isn't a token...
        new HeaderContentDisposition('@');
    }

    public function testInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "invalid name" for the header "Content-Disposition" is not valid'
        );

        // cannot contain spaces...
        new HeaderContentDisposition('foo', ['invalid name' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Content-Disposition" is not valid'
        );

        new HeaderContentDisposition('foo', [0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "Content-Disposition" is not valid'
        );

        // cannot contain quotes...
        new HeaderContentDisposition('foo', ['name' => '"invalid value"']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Content-Disposition" is not valid'
        );

        new HeaderContentDisposition('foo', ['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderContentDisposition('foo', ['bar' => 'baz']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentDisposition('foo', ['bar' => 'baz']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
