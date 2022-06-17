<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\AbstractHeader;
use Sunrise\Http\Header\HeaderInterface;

class AbstractHeaderTest extends TestCase
{
    public function testContracts()
    {
        $header = $this->createMock(AbstractHeader::class);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testBuild()
    {
        $header = $this->createMock(AbstractHeader::class);

        $header->method('getFieldName')->willReturn('x-foo');
        $header->method('getFieldValue')->willReturn('bar');

        $this->assertSame('x-foo: bar', $header->__toString());
    }

    public function testIterator()
    {
        $header = $this->createMock(AbstractHeader::class);

        $header->method('getFieldName')->willReturn('x-foo');
        $header->method('getFieldValue')->willReturn('bar');

        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame('x-foo', $iterator->current());

        $iterator->next();
        $this->assertSame('bar', $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
