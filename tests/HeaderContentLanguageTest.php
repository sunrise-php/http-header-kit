<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentLanguage;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentLanguageTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentLanguage('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentLanguage('invalid value');
    }

    public function testConstructorWithVeryLongValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentLanguage('VERYLONGVALUE');
    }

    public function testSetValue()
    {
        $header = new HeaderContentLanguage('value-first');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

        $this->assertSame([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderContentLanguage('value-first', 'value-second');

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

        $header = new HeaderContentLanguage('value');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentLanguage('value');

        $header->setValue('invalid value');
    }

    public function testSetVeryLongValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentLanguage('value');

        $header->setValue('VERYLONGVALUE');
    }

    public function testGetValue()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertSame(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertSame('Content-Language', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderContentLanguage('value');

        $this->assertSame('Content-Language: value', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderContentLanguage('value-first', 'value-second', 'value-third');

        $this->assertSame('Content-Language: value-first, value-second, value-third', (string) $header);
    }
}
