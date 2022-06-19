<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderTrailer;

class HeaderTrailerTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderTrailer('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderTrailer('foo');

        $this->assertSame('Trailer', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderTrailer('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The value "" for the header "Trailer" is not valid'
        );

        new HeaderTrailer('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The value "@" for the header "Trailer" is not valid'
        );

        // isn't a token...
        new HeaderTrailer('@');
    }

    public function testBuild()
    {
        $header = new HeaderTrailer('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderTrailer('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
