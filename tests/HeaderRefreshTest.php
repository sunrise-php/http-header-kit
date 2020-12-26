<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderRefresh;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Uri\Uri;

class HeaderRefreshTest extends TestCase
{
    public function testConstructor()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidDelay()
    {
        $this->expectException(\InvalidArgumentException::class);

        $home = new Uri('/');

        new HeaderRefresh(-1, $home);
    }

    public function testSetDelay()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertInstanceOf(HeaderInterface::class, $header->setDelay(1));

        $this->assertEquals(1, $header->getDelay());
    }

    public function testSetInvalidDelay()
    {
        $this->expectException(\InvalidArgumentException::class);

        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $header->setDelay(-1);
    }

    public function testSetUri()
    {
        $home = new Uri('/');

        $login = new Uri('/login');

        $header = new HeaderRefresh(0, $home);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri($login));

        $this->assertEquals($login, $header->getUri());
    }

    public function testGetDelay()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertEquals(0, $header->getDelay());
    }

    public function testGetUri()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertEquals($home, $header->getUri());
    }

    public function testGetFieldName()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertEquals('Refresh', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertEquals('0; url=/', $header->getFieldValue());
    }

    public function testToString()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertEquals('Refresh: 0; url=/', (string) $header);
    }

    public function testSetToMessage()
    {
        $home = new Uri('/');
        $header = new HeaderRefresh(0, $home);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $home = new Uri('/');
        $header = new HeaderRefresh(0, $home);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
