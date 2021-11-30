<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderConnection;
use Sunrise\Http\Header\HeaderInterface;

class HeaderConnectionTest extends TestCase
{
    public function testConstants()
    {
        $this->assertSame('close', HeaderConnection::CONNECTION_CLOSE);
        $this->assertSame('keep-alive', HeaderConnection::CONNECTION_KEEP_ALIVE);
    }

    public function testConstructor()
    {
        $header = new HeaderConnection('value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderConnection('invalid value');
    }

    public function testSetValue()
    {
        $header = new HeaderConnection('value');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('new-value'));

        $this->assertSame('new-value', $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderConnection('value');

        $header->setValue('invalid value');
    }

    public function testGetValue()
    {
        $header = new HeaderConnection('value');

        $this->assertSame('value', $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderConnection('value');

        $this->assertSame('Connection', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderConnection('value');

        $this->assertSame('value', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderConnection('value');

        $this->assertSame('Connection: value', (string) $header);
    }
}
