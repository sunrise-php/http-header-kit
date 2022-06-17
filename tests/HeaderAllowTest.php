<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAllow;

class HeaderAllowTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAllow('GET');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAllow('GET');

        $this->assertSame('Allow', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAllow('GET');

        $this->assertSame('GET', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderAllow('HEAD', 'GET', 'POST');

        $this->assertSame('HEAD, GET, POST', $header->getFieldValue());
    }

    public function testValueCapitalizing()
    {
        $header = new HeaderAllow('head', 'get', 'post');

        $this->assertSame('HEAD, GET, POST', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Allow" is not valid');

        new HeaderAllow('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Allow" is not valid');

        new HeaderAllow('head', '', 'post');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Allow" is not valid');

        // isn't a token...
        new HeaderAllow('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Allow" is not valid');

        // isn't a token...
        new HeaderAllow('head', '@', 'post');
    }

    public function testBuild()
    {
        $header = new HeaderAllow('GET');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAllow('GET');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
