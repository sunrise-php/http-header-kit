<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderClearSiteData;

class HeaderClearSiteDataTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderClearSiteData('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderClearSiteData('foo');

        $this->assertSame('Clear-Site-Data', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderClearSiteData('foo');

        $this->assertSame('"foo"', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderClearSiteData('foo', 'bar', 'baz');

        $this->assertSame('"foo", "bar", "baz"', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $header = new HeaderClearSiteData('');

        $this->assertSame('""', $header->getFieldValue());
    }

    public function testEmptyValueAmongOthers()
    {
        $header = new HeaderClearSiteData('foo', '', 'baz');

        $this->assertSame('"foo", "", "baz"', $header->getFieldValue());
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value ""invalid value"" for the header "Clear-Site-Data" is not valid');

        // cannot contain quotes...
        new HeaderClearSiteData('"invalid value"');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value ""bar"" for the header "Clear-Site-Data" is not valid');

        // cannot contain quotes...
        new HeaderClearSiteData('foo', '"bar"', 'baz');
    }

    public function testBuild()
    {
        $header = new HeaderClearSiteData('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderClearSiteData('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
