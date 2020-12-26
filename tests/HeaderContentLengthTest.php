<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentLength;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentLengthTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentLength(0);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentLength(-1);
    }

    public function testSetLength()
    {
        $header = new HeaderContentLength(0);

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue(1));

        $this->assertEquals(1, $header->getValue());
    }

    public function testSetInvalidLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentLength(0);

        $header->setValue(-1);
    }

    public function testGetLength()
    {
        $header = new HeaderContentLength(0);

        $this->assertEquals(0, $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentLength(0);

        $this->assertEquals('Content-Length', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentLength(0);

        $this->assertEquals('0', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderContentLength(0);

        $this->assertEquals('Content-Length: 0', (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderContentLength(0);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderContentLength(0);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
