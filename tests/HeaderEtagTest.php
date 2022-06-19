<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderEtag;

class HeaderEtagTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderEtag('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderEtag('foo');

        $this->assertSame('ETag', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderEtag('foo');

        $this->assertSame('"foo"', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $header = new HeaderEtag('');

        $this->assertSame('""', $header->getFieldValue());
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value ""invalid value"" for the header "ETag" is not valid');

        // cannot contain quotes...
        new HeaderEtag('"invalid value"');
    }

    public function testBuild()
    {
        $header = new HeaderEtag('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderEtag('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
