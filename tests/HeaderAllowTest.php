<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAllow;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAllowTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAllow('head');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAllow('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAllow('invalid method');
    }

    public function testSetValue()
    {
        $header = new HeaderAllow('head');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('get'));

        $this->assertEquals([
            'HEAD',
            'GET',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderAllow('head', 'get');

        $header->setValue('post', 'patch');

        $this->assertEquals([
            'HEAD',
            'GET',
            'POST',
            'PATCH',
        ], $header->getValue());
    }

    public function testSetEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAllow('head');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAllow('head');

        $header->setValue('invalid method');
    }

    public function testGetValue()
    {
        $header = new HeaderAllow('head');

        $this->assertEquals(['HEAD'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderAllow('head');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertEquals([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAllow('head');

        $this->assertEquals('Allow', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAllow('head');

        $this->assertEquals('HEAD', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderAllow('head');

        $this->assertEquals('Allow: HEAD', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderAllow('head', 'get', 'post');

        $this->assertEquals('Allow: HEAD, GET, POST', (string) $header);
    }
}
