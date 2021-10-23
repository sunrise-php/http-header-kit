<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderCacheControl;
use Sunrise\Http\Header\HeaderInterface;

class HeaderCacheControlTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderCacheControl([]);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderCacheControl(['invalid name' => 'value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderCacheControl(['name' => '"invalid value"']);
    }

    public function testSetParameter()
    {
        $header = new HeaderCacheControl(['name' => 'value']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameter('name', 'overwritten-value'));

        $this->assertEquals(['name' => 'overwritten-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $header = new HeaderCacheControl([]);

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

        $header = new HeaderCacheControl([]);

        $header->setParameter('invalid name', 'value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderCacheControl([]);

        $header->setParameter('name', '"invalid value"');
    }

    public function testSetParameters()
    {
        $header = new HeaderCacheControl([
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

        $header = new HeaderCacheControl([]);

        $header->setParameters(['invalid name' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderCacheControl([]);

        $header->setParameters(['name' => '"invalid value"']);
    }

    public function testGetParameters()
    {
        $header = new HeaderCacheControl(['name' => 'value']);

        $this->assertEquals(['name' => 'value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $header = new HeaderCacheControl(['name-1' => 'value-1']);

        $header->setParameter('name-2', 'value-2');
        $header->setParameter('name-3', 'value-3');

        $this->assertInstanceOf(HeaderInterface::class, $header->clearParameters());

        $this->assertEquals([], $header->getParameters());
    }

    public function testGetFieldName()
    {
        $header = new HeaderCacheControl([]);

        $this->assertEquals('Cache-Control', $header->getFieldName());
    }

    public function testGetFieldValueWithoutParameterValue()
    {
        $header = new HeaderCacheControl(['name' => '']);

        $this->assertEquals('name', $header->getFieldValue());
    }

    public function testGetFieldValueWithParameterValueAsToken()
    {
        $header = new HeaderCacheControl(['name' => 'token']);

        $this->assertEquals('name=token', $header->getFieldValue());
    }

    public function testGetFieldValueWithParameterValueAsQuotedString()
    {
        $header = new HeaderCacheControl(['name' => 'quoted string']);

        $this->assertEquals('name="quoted string"', $header->getFieldValue());
    }

    public function testToStringWithoutParameterValue()
    {
        $header = new HeaderCacheControl(['name' => '']);

        $this->assertEquals('Cache-Control: name', (string) $header);
    }

    public function testToStringWithParameterValueAsToken()
    {
        $header = new HeaderCacheControl(['name' => 'token']);

        $this->assertEquals('Cache-Control: name=token', (string) $header);
    }

    public function testToStringWithParameterValueAsQuotedString()
    {
        $header = new HeaderCacheControl(['name' => 'quoted string']);

        $this->assertEquals('Cache-Control: name="quoted string"', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $header = new HeaderCacheControl([
            'name-1' => '',
            'name-2' => 'token',
            'name-3' => 'quoted string',
        ]);

        $this->assertEquals('Cache-Control: name-1, name-2=token, name-3="quoted string"', (string) $header);
    }
}
