<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderCookie;
use Sunrise\Http\Header\HeaderInterface;

class HeaderCookieTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderCookie();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructor()
    {
        $header = new HeaderCookie(['foo', 'bar']);

        $this->assertSame(['foo', 'bar'], $header->getValue());
    }

    public function testSetValue()
    {
        $header = new HeaderCookie();

        $this->assertInstanceOf(HeaderCookie::class, $header->setValue(['foo', 'bar']));

        $this->assertSame(['foo', 'bar'], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderCookie();

        $this->assertSame('Cookie', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderCookie([
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => ['qux'],
        ]);

        $this->assertSame('foo=bar; bar=baz; baz%5B0%5D=qux', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderCookie([
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => ['qux'],
        ]);

        $this->assertSame('Cookie: foo=bar; bar=baz; baz%5B0%5D=qux', (string) $header);
    }
}
