<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAccessControlAllowCredentials;

class HeaderAccessControlAllowCredentialsTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertSame('Access-Control-Allow-Credentials', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertSame('true', $header->getFieldValue());
    }

    public function testBuild()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAccessControlAllowCredentials();
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
