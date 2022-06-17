<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderLink;
use Sunrise\Uri\Uri;

class HeaderLinkTest extends TestCase
{
    public function testContracts()
    {
        $uri = new Uri('/');
        $header = new HeaderLink($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $uri = new Uri('/');
        $header = new HeaderLink($uri);

        $this->assertSame('Link', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $uri = new Uri('/');
        $header = new HeaderLink($uri);

        $this->assertSame('</>', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'foo' => '',
        ]);

        $this->assertSame('</>; foo=""', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'foo' => 'token',
        ]);

        $this->assertSame('</>; foo="token"', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'foo' => 'quoted string',
        ]);

        $this->assertSame('</>; foo="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'foo' => 1,
        ]);

        $this->assertSame('</>; foo="1"', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'foo' => '',
            'bar' => 'token',
            'baz' => 'quoted string',
            'qux' => 1,
        ]);

        $this->assertSame('</>; foo=""; bar="token"; baz="quoted string"; qux="1"', $header->getFieldValue());
    }

    public function testInvalidParameterName()
    {
        $uri = new Uri('/');

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "invalid name" for the header "Link" is not valid'
        );

        // cannot contain spaces...
        new HeaderLink($uri, ['invalid name' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $uri = new Uri('/');

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Link" is not valid'
        );

        new HeaderLink($uri, [0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $uri = new Uri('/');

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "Link" is not valid'
        );

        // cannot contain quotes...
        new HeaderLink($uri, ['name' => '"invalid value"']);
    }

    public function testInvalidParameterValueType()
    {
        $uri = new Uri('/');

        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Link" is not valid'
        );

        // cannot contain quotes...
        new HeaderLink($uri, ['name' => []]);
    }

    public function testBuild()
    {
        $uri = new Uri('/');
        $header = new HeaderLink($uri, ['foo' => 'bar']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $uri = new Uri('/');
        $header = new HeaderLink($uri, ['foo' => 'bar']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
