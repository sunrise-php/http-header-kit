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

        $this->assertSame(1, $header->getDelay());
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

        $this->assertSame($login, $header->getUri());
    }

    public function testGetDelay()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertSame(0, $header->getDelay());
    }

    public function testGetUri()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertSame($home, $header->getUri());
    }

    public function testGetFieldName()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertSame('Refresh', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertSame('0; url=/', $header->getFieldValue());
    }

    public function testToString()
    {
        $home = new Uri('/');

        $header = new HeaderRefresh(0, $home);

        $this->assertSame('Refresh: 0; url=/', (string) $header);
    }
}
