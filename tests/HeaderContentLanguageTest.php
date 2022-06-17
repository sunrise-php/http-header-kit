<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentLanguage;

class HeaderContentLanguageTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderContentLanguage('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentLanguage('foo');

        $this->assertSame('Content-Language', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentLanguage('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testSeveralValues()
    {
        $header = new HeaderContentLanguage('foo', 'bar', 'baz');

        $this->assertSame('foo, bar, baz', $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Content-Language" is not valid');

        new HeaderContentLanguage('');
    }

    public function testEmptyValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Content-Language" is not valid');

        new HeaderContentLanguage('foo', '', 'baz');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Content-Language" is not valid');

        // isn't a token...
        new HeaderContentLanguage('@');
    }

    public function testInvalidValueAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Content-Language" is not valid');

        // isn't a token...
        new HeaderContentLanguage('foo', '@', 'baz');
    }

    public function testInvalidValueLength()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "VERYLONGWORD" for the header "Content-Language" is not valid');

        // isn't a token...
        new HeaderContentLanguage('VERYLONGWORD');
    }

    public function testInvalidValueLengthAmongOthers()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "VERYLONGWORD" for the header "Content-Language" is not valid');

        // isn't a token...
        new HeaderContentLanguage('foo', 'VERYLONGWORD', 'baz');
    }

    public function testBuild()
    {
        $header = new HeaderContentLanguage('foo');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentLanguage('foo');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
