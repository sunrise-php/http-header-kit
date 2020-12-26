<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlAllowOrigin;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Uri\Uri;

class HeaderAccessControlAllowOriginTest extends TestCase
{
    public function testConstructor()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithoutUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidUriThatWithoutScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlAllowOrigin(new Uri('//localhost'));
    }

    public function testConstructorWithInvalidUriThatWithoutHost()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlAllowOrigin(new Uri('http:'));
    }

    public function testSetUri()
    {
        $uri1 = new Uri('http://localhost');

        $uri2 = new Uri('http://localhost:3000');

        $header = new HeaderAccessControlAllowOrigin($uri1);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri($uri2));

        $this->assertEquals($uri2, $header->getUri());
    }

    public function testSetEmptyUri()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri(null));

        $this->assertEquals(null, $header->getUri());
    }

    public function testSetInvalidUriThatWithoutScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlAllowOrigin(null);

        $header->setUri(new Uri('//localhost'));
    }

    public function testSetInvalidUriThatWithoutHost()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlAllowOrigin(null);

        $header->setUri(new Uri('http:'));
    }

    public function testGetUri()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals($uri, $header->getUri());
    }

    public function testGetEmptyUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertEquals(null, $header->getUri());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertEquals('Access-Control-Allow-Origin', $header->getFieldName());
    }

    public function testGetFieldValueWithoutUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertEquals('*', $header->getFieldValue());
    }

    public function testGetFieldValueWithSchemeAndHost()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('http://localhost', $header->getFieldValue());
    }

    public function testGetFieldValueWithSchemeAndHostAndPort()
    {
        $uri = new Uri('http://localhost:3000');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('http://localhost:3000', $header->getFieldValue());
    }

    public function testGetFieldValueWithValidOrigin()
    {
        $uri = new Uri('http://user:pass@localhost:3000/index.php?q#h');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('http://localhost:3000', $header->getFieldValue());
    }

    public function testToStringWithoutUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertEquals('Access-Control-Allow-Origin: *', (string) $header);
    }

    public function testToStringWithSchemeAndHost()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('Access-Control-Allow-Origin: http://localhost', (string) $header);
    }

    public function testToStringWithSchemeAndHostAndPort()
    {
        $uri = new Uri('http://localhost:3000');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('Access-Control-Allow-Origin: http://localhost:3000', (string) $header);
    }

    public function testToStringWithValidOrigin()
    {
        $uri = new Uri('http://user:pass@localhost:3000/index.php?q#h');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertEquals('Access-Control-Allow-Origin: http://localhost:3000', (string) $header);
    }

    public function testSetToMessage()
    {
        $uri = new Uri('http://localhost');
        $header = new HeaderAccessControlAllowOrigin($uri);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $uri = new Uri('http://localhost');
        $header = new HeaderAccessControlAllowOrigin($uri);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
