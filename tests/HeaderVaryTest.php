<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderVary;

class HeaderVaryTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderVary('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderVary('foo');

        $this->assertSame('Vary', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderVary('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderVary('foo', 'bar', 'baz');

        $this->assertSame('foo, bar, baz', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Vary" is not valid');

        new HeaderVary('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Vary" is not valid');

        new HeaderVary('foo', '', 'baz');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Vary" is not valid');

        // isn't a token...
        new HeaderVary('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Vary" is not valid');

        // isn't a token...
        new HeaderVary('foo', '@', 'baz');
    }

    public function testBuild()
    {
        $header = new HeaderVary('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderVary('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
