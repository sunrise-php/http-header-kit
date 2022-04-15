<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderClearSiteData;
use Sunrise\Http\Header\HeaderInterface;

class HeaderClearSiteDataTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderClearSiteData('"invalid value"');
    }

    public function testSetValue()
    {
        $header = new HeaderClearSiteData('value-first');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

        $this->assertSame([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderClearSiteData('value-first', 'value-second');

        $header->setValue('value-third', 'value-fourth');

        $this->assertSame([
            'value-first',
            'value-second',
            'value-third',
            'value-fourth',
        ], $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderClearSiteData('value');

        $header->setValue('"invalid value"');
    }

    public function testGetValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertSame(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertSame('Clear-Site-Data', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertSame('"value"', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertSame('Clear-Site-Data: "value"', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderClearSiteData('value-first', 'value-second', 'value-third');

        $this->assertSame('Clear-Site-Data: "value-first", "value-second", "value-third"', (string) $header);
    }
}
