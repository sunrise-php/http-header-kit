<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderContentMD5;

class HeaderContentMD5Test extends TestCase
{
    public const TEST_MD5_DIGEST = 'YzRjYTQyMzhhMGI5MjM4MjBkY2M1MDlhNmY3NTg0OWI=';

    public function testContracts()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST);

        $this->assertSame('Content-MD5', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST);

        $this->assertSame(self::TEST_MD5_DIGEST, $header->getFieldValue());
    }

    public function testEmptyValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The value "" for the header "Content-MD5" is not valid'
        );

        new HeaderContentMD5('');
    }

    public function testInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The value "=invalid md5 digest=" for the header "Content-MD5" is not valid'
        );

        new HeaderContentMD5('=invalid md5 digest=');
    }

    public function testBuild()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
