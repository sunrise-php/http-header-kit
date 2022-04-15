<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentDisposition;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentDispositionTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderContentDisposition('type');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentDisposition('invalid type');
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentDisposition('type', ['parameter-name=' => 'parameter-value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentDisposition('type', ['parameter-name' => '"parameter-value"']);
    }

    public function testSetType()
    {
        $header = new HeaderContentDisposition('type');

        $this->assertInstanceOf(HeaderInterface::class, $header->setType('overwritten-type'));

        $this->assertSame('overwritten-type', $header->getType());
    }

    public function testSetInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentDisposition('type');

        $header->setType('invalid type');
    }

    public function testSetParameter()
    {
        $header = new HeaderContentDisposition('type', ['parameter-name' => 'parameter-value']);

        $this->assertInstanceOf(
            HeaderInterface::class,
            $header->setParameter('parameter-name', 'overwritten-parameter-value')
        );

        $this->assertSame(['parameter-name' => 'overwritten-parameter-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $header = new HeaderContentDisposition('type', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $header->setParameter('parameter-name-1', 'overwritten-parameter-value-1');
        $header->setParameter('parameter-name-2', 'overwritten-parameter-value-2');

        $this->assertSame([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ], $header->getParameters());
    }

    public function testSetParameterWithInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentDisposition('type');

        $header->setParameter('parameter-name=', 'parameter-value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentDisposition('type');

        $header->setParameter('parameter-name', '"parameter-value"');
    }

    public function testSetParameters()
    {
        $header = new HeaderContentDisposition('type', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameters([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ]));

        $this->assertSame([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ], $header->getParameters());
    }

    public function testSetParametersWithParameterThatContainsInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentDisposition('type');

        $header->setParameters(['invalid name' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentDisposition('type');

        $header->setParameters(['name' => '"invalid value"']);
    }

    public function testGetType()
    {
        $header = new HeaderContentDisposition('type');

        $this->assertSame('type', $header->getType());
    }

    public function testGetParameters()
    {
        $header = new HeaderContentDisposition('type', ['parameter-name' => 'parameter-value']);

        $this->assertSame(['parameter-name' => 'parameter-value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $header = new HeaderContentDisposition('type', [
            'parameter-name-1' => 'parameter-value-1',
        ]);

        $header->setParameters([
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $header->setParameter('parameter-name-3', 'parameter-value-3');

        $this->assertInstanceOf(HeaderInterface::class, $header->clearParameters());

        $this->assertSame([], $header->getParameters());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentDisposition('type');

        $this->assertSame('Content-Disposition', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentDisposition('type', ['parameter-name' => 'parameter-value']);

        $this->assertSame('type; parameter-name="parameter-value"', $header->getFieldValue());
    }

    public function testToStringWithoutParameters()
    {
        $header = new HeaderContentDisposition('type');

        $this->assertSame('Content-Disposition: type', (string) $header);
    }

    public function testToStringWithParameterWithoutValue()
    {
        $header = new HeaderContentDisposition('type', ['parameter-name' => '']);

        $this->assertSame('Content-Disposition: type; parameter-name=""', (string) $header);
    }

    public function testToStringWithOneParameter()
    {
        $header = new HeaderContentDisposition('type', ['parameter-name' => 'parameter-value']);

        $this->assertSame('Content-Disposition: type; parameter-name="parameter-value"', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $header = new HeaderContentDisposition('type', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
            'parameter-name-3' => 'parameter-value-3',
        ]);

        $expected = 'Content-Disposition: type; parameter-name-1="parameter-value-1"; ' .
                    'parameter-name-2="parameter-value-2"; parameter-name-3="parameter-value-3"';

        $this->assertSame($expected, (string) $header);
    }
}
