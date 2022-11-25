<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderCustom;

class HeaderCustomTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertSame('foo', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertSame('bar', $header->getFieldValue());
    }

    public function testInvalidFieldName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Header field-name is invalid');

        new HeaderCustom('@', 'value');
    }

    public function testInvalidFieldNameType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Header field-name must be a string');

        new HeaderCustom([], 'value');
    }

    public function testEmptyFieldValue()
    {
        $header = new HeaderCustom('foo', '');

        $this->assertSame('', $header->getFieldValue());
    }

    public function testInvalidFieldValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Header field-value is invalid');

        new HeaderCustom('foo', "\0");
    }

    public function testInvalidFieldValueType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Header field-value must be a string');

        new HeaderCustom('foo', []);
    }

    public function testBuild()
    {
        $header = new HeaderCustom('foo', 'bar');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderCustom('foo', 'bar');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
