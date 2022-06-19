<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentLocation;
use Sunrise\Uri\Uri;

class HeaderContentLocationTest extends TestCase
{
    public function testContracts()
    {
        $uri = new Uri('/');
        $header = new HeaderContentLocation($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $uri = new Uri('/');
        $header = new HeaderContentLocation($uri);

        $this->assertSame('Content-Location', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $uri = new Uri('/');
        $header = new HeaderContentLocation($uri);

        $this->assertSame('/', $header->getFieldValue());
    }

    public function testBuild()
    {
        $uri = new Uri('/');
        $header = new HeaderContentLocation($uri);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $uri = new Uri('/');
        $header = new HeaderContentLocation($uri);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
