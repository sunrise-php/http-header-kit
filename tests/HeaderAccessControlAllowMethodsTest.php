<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlAllowMethods;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlAllowMethodsTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlAllowMethods('');
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderAccessControlAllowMethods('invalid method');
    }

    public function testSetValue()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('get'));

        $this->assertSame([
            'HEAD',
            'GET',
        ], $header->getValue());
    }

    public function testSetSeveralValues()
    {
        $header = new HeaderAccessControlAllowMethods('head', 'get');

        $header->setValue('post', 'patch');

        $this->assertSame([
            'HEAD',
            'GET',
            'POST',
            'PATCH',
        ], $header->getValue());
    }

    public function testSetEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlAllowMethods('head');

        $header->setValue('');
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderAccessControlAllowMethods('head');

        $header->setValue('invalid method');
    }

    public function testGetValue()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertSame(['HEAD'], $header->getValue());
    }

    public function testResetValue()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

        $this->assertSame([], $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertSame('Access-Control-Allow-Methods', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertSame('HEAD', $header->getFieldValue());
    }

    public function testToStringWithOneValue()
    {
        $header = new HeaderAccessControlAllowMethods('head');

        $this->assertSame('Access-Control-Allow-Methods: HEAD', (string) $header);
    }

    public function testToStringWithSeveralValues()
    {
        $header = new HeaderAccessControlAllowMethods('head', 'get', 'post');

        $this->assertSame('Access-Control-Allow-Methods: HEAD, GET, POST', (string) $header);
    }
}
