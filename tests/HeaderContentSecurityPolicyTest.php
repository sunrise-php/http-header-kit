<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentSecurityPolicy;

class HeaderContentSecurityPolicyTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $this->assertSame('Content-Security-Policy', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentSecurityPolicy([]);

        $this->assertSame('', $header->getFieldValue());
    }

    public function testParameterWithoutValue()
    {
        $header = new HeaderContentSecurityPolicy([
            'foo' => '',
        ]);

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithValue()
    {
        $header = new HeaderContentSecurityPolicy([
            'foo' => 'bar',
        ]);

        $this->assertSame('foo bar', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderContentSecurityPolicy([
            'foo' => 1,
        ]);

        $this->assertSame('foo 1', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderContentSecurityPolicy([
            'foo' => '',
            'bar' => 'bat',
            'baz' => 1,
        ]);

        $this->assertSame('foo; bar bat; baz 1', $header->getFieldValue());
    }

    public function testInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "name=" for the header "Content-Security-Policy" is not valid'
        );

        new HeaderContentSecurityPolicy(['name=' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "Content-Security-Policy" is not valid'
        );

        new HeaderContentSecurityPolicy([0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ";value" for the header "Content-Security-Policy" is not valid'
        );

        new HeaderContentSecurityPolicy(['name' => ';value']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "Content-Security-Policy" is not valid'
        );

        new HeaderContentSecurityPolicy(['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderContentSecurityPolicy(['foo' => 'bar']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentSecurityPolicy(['foo' => 'bar']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
