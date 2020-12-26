<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlAllowCredentials;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlAllowCredentialsTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertEquals('Access-Control-Allow-Credentials', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertEquals('true', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertEquals('Access-Control-Allow-Credentials: true', (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
