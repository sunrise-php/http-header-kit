<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderConnection;
use Sunrise\Http\Header\HeaderInterface;

class HeaderConnectionTest extends TestCase
{
    public function testConstants()
    {
        $this->assertEquals('close', HeaderConnection::CONNECTION_CLOSE);
        $this->assertEquals('keep-alive', HeaderConnection::CONNECTION_KEEP_ALIVE);
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

        $this->assertEquals('new-value', $header->getValue());
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

        $this->assertEquals('value', $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderConnection('value');

        $this->assertEquals('Connection', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderConnection('value');

        $this->assertEquals('value', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderConnection('value');

        $this->assertEquals('Connection: value', (string) $header);
    }
}
