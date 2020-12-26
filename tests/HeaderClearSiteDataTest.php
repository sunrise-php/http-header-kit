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

        $this->assertEquals([
            'value-first',
            'value-second',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderClearSiteData('value-first', 'value-second');

        $header->setValue('value-third', 'value-fourth');

        $this->assertEquals([
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

        $this->assertEquals(['value'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertEquals([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertEquals('Clear-Site-Data', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertEquals('"value"', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderClearSiteData('value');

        $this->assertEquals('Clear-Site-Data: "value"', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderClearSiteData('value-first', 'value-second', 'value-third');

        $this->assertEquals('Clear-Site-Data: "value-first", "value-second", "value-third"', (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderClearSiteData('value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderClearSiteData('value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
