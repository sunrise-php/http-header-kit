<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderVary;
use Sunrise\Http\Header\HeaderInterface;

class HeaderVaryTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderVary('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderVary('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderVary('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderVary('value-first');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

        $this->assertSame([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderVary('value-first', 'value-second');

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

        $header = new HeaderVary('value');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderVary('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderVary('value');

        $this->assertSame(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderVary('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderVary('value');

        $this->assertSame('Vary', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderVary('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderVary('value');

        $this->assertSame('Vary: value', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderVary('value-first', 'value-second', 'value-third');

        $this->assertSame('Vary: value-first, value-second, value-third', (string) $header);
    }
}
