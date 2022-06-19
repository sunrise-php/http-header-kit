<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentRange;

class HeaderContentRangeTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertSame('Content-Range', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $this->assertSame('bytes 0-1/2', $header->getFieldValue());
    }

    public function testInvalidFirstBytePosition()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The "first-byte-pos" value of the content range ' .
            'must be less than or equal to the "last-byte-pos" value'
        );

        new HeaderContentRange(2, 1, 2);
    }

    public function testInvalidLastBytePosition()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The "last-byte-pos" value of the content range ' .
            'must be less than the "instance-length" value'
        );

        new HeaderContentRange(0, 2, 2);
    }

    public function testInvalidInstanceLength()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The "last-byte-pos" value of the content range ' .
            'must be less than the "instance-length" value'
        );

        new HeaderContentRange(0, 1, 1);
    }

    public function testBuild()
    {
        $header = new HeaderContentRange(0, 1, 2);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentRange(0, 1, 2);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
