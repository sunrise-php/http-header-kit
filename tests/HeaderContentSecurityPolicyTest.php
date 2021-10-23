<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentSecurityPolicy;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentSecurityPolicyTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentSecurityPolicy(['name=' => 'value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentSecurityPolicy(['name' => ';value']);
    }

    public function testSetParameter()
    {
        $header = new HeaderContentSecurityPolicy(['name' => 'value']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameter('name', 'overwritten-value'));

        $this->assertEquals(['name' => 'overwritten-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $header->setParameter('name-1', 'value-1');
        $header->setParameter('name-2', 'value-2');

        $this->assertEquals([
            'name-1' => 'value-1',
            'name-2' => 'value-2',
        ], $header->getParameters());
    }

    public function testSetParameterWithInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentSecurityPolicy([]);

        $header->setParameter('name=', 'value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentSecurityPolicy([]);

        $header->setParameter('name', ';value');
    }

    public function testSetParameters()
    {
        $header = new HeaderContentSecurityPolicy([
            'name-1' => 'value-1',
            'name-2' => 'value-2',
        ]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameters([
            'name-1' => 'overwritten-value-1',
            'name-2' => 'overwritten-value-2',
        ]));

        $this->assertEquals([
            'name-1' => 'overwritten-value-1',
            'name-2' => 'overwritten-value-2',
        ], $header->getParameters());
    }

    public function testSetParametersWithParameterThatContainsInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentSecurityPolicy([]);

        $header->setParameters(['name=' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentSecurityPolicy([]);

        $header->setParameters(['name' => ';value']);
    }

    public function testGetParameters()
    {
        $header = new HeaderContentSecurityPolicy(['name' => 'value']);

        $this->assertEquals(['name' => 'value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $header = new HeaderContentSecurityPolicy(['name-1' => 'value-1']);

        $header->setParameter('name-2', 'value-2');
        $header->setParameter('name-3', 'value-3');

        $this->assertInstanceOf(HeaderInterface::class, $header->clearParameters());

        $this->assertEquals([], $header->getParameters());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $this->assertEquals('Content-Security-Policy', $header->getFieldName());
    }

    public function testGetFieldValueWithoutParameterValue()
    {
        $header = new HeaderContentSecurityPolicy(['name' => '']);

        $this->assertEquals('name', $header->getFieldValue());
    }

    public function testGetFieldValueWithParameterValue()
    {
        $header = new HeaderContentSecurityPolicy(['name' => 'value']);

        $this->assertEquals('name value', $header->getFieldValue());
    }

    public function testToStringWithoutParameterValue()
    {
        $header = new HeaderContentSecurityPolicy(['name' => '']);

        $this->assertEquals('Content-Security-Policy: name', (string) $header);
    }

    public function testToStringWithParameterValue()
    {
        $header = new HeaderContentSecurityPolicy(['name' => 'value']);

        $this->assertEquals('Content-Security-Policy: name value', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $header = new HeaderContentSecurityPolicy([
            'name-1' => '',
            'name-2' => 'value-2',
            'name-3' => 'value-3',
        ]);

        $this->assertEquals('Content-Security-Policy: name-1; name-2 value-2; name-3 value-3', (string) $header);
    }
}
