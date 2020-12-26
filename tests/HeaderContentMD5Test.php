<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderContentMD5;
use Sunrise\Http\Header\HeaderInterface;

class HeaderContentMD5Test extends TestCase
{
    public const TEST_MD5_DIGEST_1 = 'YzRjYTQyMzhhMGI5MjM4MjBkY2M1MDlhNmY3NTg0OWI=';
    public const TEST_MD5_DIGEST_2 = 'YzgxZTcyOGQ5ZDRjMmY2MzZmMDY3Zjg5Y2MxNDg2MmM=';

    public function testConstructor()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderContentMD5('=invalid md5 digest=');
    }

    public function testSetValue()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue(self::TEST_MD5_DIGEST_2));

        $this->assertEquals(self::TEST_MD5_DIGEST_2, $header->getValue());
    }

    public function testSetInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $header->setValue('=invalid md5 digest=');
    }

    public function testGetValue()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertEquals(self::TEST_MD5_DIGEST_1, $header->getValue());
    }

    public function testGetFieldName()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertEquals('Content-MD5', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertEquals(self::TEST_MD5_DIGEST_1, $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $this->assertEquals('Content-MD5: ' . self::TEST_MD5_DIGEST_1, (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderContentMD5(self::TEST_MD5_DIGEST_1);

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
