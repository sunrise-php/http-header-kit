<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderRefresh;
use Sunrise\Uri\Uri;

class HeaderRefreshTest extends TestCase
{
    public function testContracts()
    {
        $uri = new Uri('/');
        $header = new HeaderRefresh(0, $uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $uri = new Uri('/');
        $header = new HeaderRefresh(0, $uri);

        $this->assertSame('Refresh', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $uri = new Uri('/');
        $header = new HeaderRefresh(0, $uri);

        $this->assertSame('0; url=/', $header->getFieldValue());
    }

    public function testInvalidDelay()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The delay "-1" for the header "Refresh" is not valid');

        $uri = new Uri('/');

        new HeaderRefresh(-1, $uri);
    }

    public function testBuild()
    {
        $uri = new Uri('/');
        $header = new HeaderRefresh(0, $uri);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $uri = new Uri('/');
        $header = new HeaderRefresh(0, $uri);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
