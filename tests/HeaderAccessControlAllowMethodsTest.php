<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAccessControlAllowMethods;

class HeaderAccessControlAllowMethodsTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAccessControlAllowMethods('GET');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAccessControlAllowMethods('GET');

        $this->assertSame('Access-Control-Allow-Methods', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAccessControlAllowMethods('GET');

        $this->assertSame('GET', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderAccessControlAllowMethods('HEAD', 'GET', 'POST');

        $this->assertSame('HEAD, GET, POST', $header->getFieldValue());
    }

    public function testValueCapitalizing()
    {
        $header = new HeaderAccessControlAllowMethods('head', 'get', 'post');

        $this->assertSame('HEAD, GET, POST', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Allow-Methods" is not valid');

        new HeaderAccessControlAllowMethods('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Access-Control-Allow-Methods" is not valid');

        new HeaderAccessControlAllowMethods('head', '', 'post');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Access-Control-Allow-Methods" is not valid');

        // isn't a token...
        new HeaderAccessControlAllowMethods('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Access-Control-Allow-Methods" is not valid');

        // isn't a token...
        new HeaderAccessControlAllowMethods('head', '@', 'post');
    }

    public function testBuild()
    {
        $header = new HeaderAccessControlAllowMethods('GET');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAccessControlAllowMethods('GET');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
