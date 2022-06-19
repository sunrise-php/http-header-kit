<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderLocation;
use Sunrise\Uri\Uri;

class HeaderLocationTest extends TestCase
{
    public function testContracts()
    {
        $uri = new Uri('/');
        $header = new HeaderLocation($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $uri = new Uri('/');
        $header = new HeaderLocation($uri);

        $this->assertSame('Location', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $uri = new Uri('/');
        $header = new HeaderLocation($uri);

        $this->assertSame('/', $header->getFieldValue());
    }

    public function testBuild()
    {
        $uri = new Uri('/');
        $header = new HeaderLocation($uri);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $uri = new Uri('/');
        $header = new HeaderLocation($uri);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
