<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderLocation;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Uri\Uri;

class HeaderLocationTest extends TestCase
{
    public function testConstructor()
    {
        $home = new Uri('/');

        $header = new HeaderLocation($home);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testSetUri()
    {
        $home = new Uri('/');

        $news = new Uri('/news');

        $header = new HeaderLocation($home);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri($news));

        $this->assertSame($news, $header->getUri());
    }

    public function testGetUri()
    {
        $home = new Uri('/');

        $header = new HeaderLocation($home);

        $this->assertSame($home, $header->getUri());
    }

    public function testGetFieldName()
    {
        $home = new Uri('/');

        $header = new HeaderLocation($home);

        $this->assertSame('Location', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $home = new Uri('/');

        $header = new HeaderLocation($home);

        $this->assertSame('/', $header->getFieldValue());
    }

    public function testToString()
    {
        $home = new Uri('/');

        $header = new HeaderLocation($home);

        $this->assertSame('Location: /', (string) $header);
    }
}
