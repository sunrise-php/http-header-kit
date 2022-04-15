<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlAllowCredentials;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlAllowCredentialsTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testGetFieldName()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertSame('Access-Control-Allow-Credentials', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertSame('true', $header->getFieldValue());
    }

    public function testToString()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $this->assertSame('Access-Control-Allow-Credentials: true', (string) $header);
    }

    public function testIteration()
    {
        $header = new HeaderAccessControlAllowCredentials();

        $parameters = \iterator_to_array($header);

        $this->assertSame([
            $header->getFieldName(),
            $header->getFieldValue(),
        ], $parameters);
    }
}
