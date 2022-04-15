<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderCustom;
use Sunrise\Http\Header\HeaderInterface;

class HeaderCustomTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidFieldName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Name of the header "@" is not valid');

        new HeaderCustom('@', 'value');
    }

    public function testConstructorWithInvalidFieldValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Value of the header "foo" is not valid');

        new HeaderCustom('foo', "\0");
    }

    public function testGetFieldName()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertEquals('foo', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertEquals('bar', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderCustom('foo', 'bar');

        $this->assertEquals('foo: bar', (string) $header);
    }
}
