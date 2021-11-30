<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlExposeHeaders;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlExposeHeadersTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlExposeHeaders('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlExposeHeaders('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderAccessControlExposeHeaders('value-first');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

        $this->assertSame([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderAccessControlExposeHeaders('value-first', 'value-second');

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

        $header = new HeaderAccessControlExposeHeaders('value');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlExposeHeaders('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertSame(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertSame('Access-Control-Expose-Headers', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderAccessControlExposeHeaders('value');

        $this->assertSame('Access-Control-Expose-Headers: value', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderAccessControlExposeHeaders('value-first', 'value-second', 'value-third');

        $this->assertSame('Access-Control-Expose-Headers: value-first, value-second, value-third', (string) $header);
    }
}
