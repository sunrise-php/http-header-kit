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

        $this->assertSame($uri2, $header->getUri());
    }

    public function testSetEmptyUri()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri(null));

        $this->assertNull($header->getUri());
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

        $this->assertSame($uri, $header->getUri());
    }

    public function testGetEmptyUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertNull($header->getUri());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertSame('Access-Control-Allow-Origin', $header->getFieldName());
    }

    public function testGetFieldValueWithoutUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertSame('*', $header->getFieldValue());
    }

    public function testGetFieldValueWithSchemeAndHost()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('http://localhost', $header->getFieldValue());
    }

    public function testGetFieldValueWithSchemeAndHostAndPort()
    {
        $uri = new Uri('http://localhost:3000');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('http://localhost:3000', $header->getFieldValue());
    }

    public function testGetFieldValueWithValidOrigin()
    {
        $uri = new Uri('http://user:pass@localhost:3000/index.php?q#h');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('http://localhost:3000', $header->getFieldValue());
    }

    public function testToStringWithoutUri()
    {
        $header = new HeaderAccessControlAllowOrigin(null);

        $this->assertSame('Access-Control-Allow-Origin: *', (string) $header);
    }

    public function testToStringWithSchemeAndHost()
    {
        $uri = new Uri('http://localhost');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('Access-Control-Allow-Origin: http://localhost', (string) $header);
    }

    public function testToStringWithSchemeAndHostAndPort()
    {
        $uri = new Uri('http://localhost:3000');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('Access-Control-Allow-Origin: http://localhost:3000', (string) $header);
    }

    public function testToStringWithValidOrigin()
    {
        $uri = new Uri('http://user:pass@localhost:3000/index.php?q#h');

        $header = new HeaderAccessControlAllowOrigin($uri);

        $this->assertSame('Access-Control-Allow-Origin: http://localhost:3000', (string) $header);
    }
}
