<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderTransferEncoding;
use Sunrise\Http\Header\HeaderInterface;

class HeaderTransferEncodingTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderTransferEncoding('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderTransferEncoding('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderTransferEncoding('value-first');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

        $this->assertSame([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderTransferEncoding('value-first', 'value-second');

        $header->setValue('value-third', 'value-fourth');

        $this->assertSame([
            'value-first',
            'value-second',
            'value-third',
            'value-fourth',
        ], $header->getValue());
    }

    public function testSetEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderTransferEncoding('value');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderTransferEncoding('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertSame(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertSame('Transfer-Encoding', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderTransferEncoding('value');

        $this->assertSame('Transfer-Encoding: value', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderTransferEncoding('value-first', 'value-second', 'value-third');

        $this->assertSame('Transfer-Encoding: value-first, value-second, value-third', (string) $header);
    }
}
