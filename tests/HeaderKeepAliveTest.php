<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderKeepAlive;
use Sunrise\Http\Header\HeaderInterface;

class HeaderKeepAliveTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderKeepAlive([]);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderKeepAlive(['invalid name' => 'value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderKeepAlive(['name' => '"invalid value"']);
    }

    public function testSetParameter()
    {
        $header = new HeaderKeepAlive(['name' => 'value']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameter('name', 'overwritten-value'));

        $this->assertSame(['name' => 'overwritten-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $header = new HeaderKeepAlive([]);

        $header->setParameter('name-1', 'value-1');
        $header->setParameter('name-2', 'value-2');

        $this->assertSame([
            'name-1' => 'value-1',
            'name-2' => 'value-2',
        ], $header->getParameters());
    }

    public function testSetParameterWithInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderKeepAlive([]);

        $header->setParameter('invalid name', 'value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderKeepAlive([]);

        $header->setParameter('name', '"invalid value"');
    }

    public function testSetParameters()
    {
        $header = new HeaderKeepAlive([
            'name-1' => 'value-1',
            'name-2' => 'value-2',
        ]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameters([
            'name-1' => 'overwritten-value-1',
            'name-2' => 'overwritten-value-2',
        ]));

        $this->assertSame([
            'name-1' => 'overwritten-value-1',
            'name-2' => 'overwritten-value-2',
        ], $header->getParameters());
    }

    public function testSetParametersWithParameterThatContainsInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderKeepAlive([]);

        $header->setParameters(['invalid name' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderKeepAlive([]);

        $header->setParameters(['name' => '"invalid value"']);
    }

    public function testGetParameters()
    {
        $header = new HeaderKeepAlive(['name' => 'value']);

        $this->assertSame(['name' => 'value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $header = new HeaderKeepAlive(['name-1' => 'value-1']);

        $header->setParameter('name-2', 'value-2');
        $header->setParameter('name-3', 'value-3');

        $this->assertInstanceOf(HeaderInterface::class, $header->clearParameters());

        $this->assertSame([], $header->getParameters());
    }

    public function testGetFieldName()
    {
        $header = new HeaderKeepAlive([]);

        $this->assertSame('Keep-Alive', $header->getFieldName());
    }

    public function testGetFieldValueWithoutParameterValue()
    {
        $header = new HeaderKeepAlive(['name' => '']);

        $this->assertSame('name', $header->getFieldValue());
    }

    public function testGetFieldValueWithParameterValueAsToken()
    {
        $header = new HeaderKeepAlive(['name' => 'token']);

        $this->assertSame('name=token', $header->getFieldValue());
    }

    public function testGetFieldValueWithParameterValueAsQuotedString()
    {
        $header = new HeaderKeepAlive(['name' => 'quoted string']);

        $this->assertSame('name="quoted string"', $header->getFieldValue());
    }

    public function testToStringWithoutParameterValue()
    {
        $header = new HeaderKeepAlive(['name' => '']);

        $this->assertSame('Keep-Alive: name', (string) $header);
    }

    public function testToStringWithParameterValueAsToken()
    {
        $header = new HeaderKeepAlive(['name' => 'token']);

        $this->assertSame('Keep-Alive: name=token', (string) $header);
    }

    public function testToStringWithParameterValueAsQuotedString()
    {
        $header = new HeaderKeepAlive(['name' => 'quoted string']);

        $this->assertSame('Keep-Alive: name="quoted string"', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $header = new HeaderKeepAlive([
            'name-1' => '',
            'name-2' => 'token',
            'name-3' => 'quoted string',
        ]);

        $this->assertSame('Keep-Alive: name-1, name-2=token, name-3="quoted string"', (string) $header);
    }
}
