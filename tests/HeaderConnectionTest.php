<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderConnection;

class HeaderConnectionTest extends TestCase
{
    public function testConstants()
    {
        $this->assertSame('close', HeaderConnection::CONNECTION_CLOSE);
        $this->assertSame('keep-alive', HeaderConnection::CONNECTION_KEEP_ALIVE);
    }

    public function testContracts()
    {
        $header = new HeaderConnection('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderConnection('foo');

        $this->assertSame('Connection', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderConnection('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Connection" is not valid');

        new HeaderConnection('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Connection" is not valid');

        // isn't a token...
        new HeaderConnection('@');
    }

    public function testBuild()
    {
        $header = new HeaderConnection('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderConnection('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
