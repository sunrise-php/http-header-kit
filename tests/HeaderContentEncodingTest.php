<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentEncoding;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentEncodingTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentEncoding('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('new-value'));

        $this->assertEquals('new-value', $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentEncoding('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertEquals('value', $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertEquals('Content-Encoding', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertEquals('value', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderContentEncoding('value');

        $this->assertEquals('Content-Encoding: value', (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderContentEncoding('value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderContentEncoding('value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
