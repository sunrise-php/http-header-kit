<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderCookie;

class HeaderCookieTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderCookie();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderCookie();

        $this->assertSame('Cookie', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderCookie([
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => [
                'qux',
            ],
        ]);

        $this->assertSame('foo=bar; bar=baz; baz%5B0%5D=qux', $header->getFieldValue());
    }

    public function testBuild()
    {
        $header = new HeaderCookie(['foo' => 'bar']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderCookie(['foo' => 'bar']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
