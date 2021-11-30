<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderRetryAfter;
use Sunrise\Http\Header\HeaderInterface;

class HeaderRetryAfterTest extends TestCase
{
    public function testConstructor()
    {
        $now = new \DateTime('now');

        $header = new HeaderRetryAfter($now);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testSetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderRetryAfter($now);

        $tomorrow = new \DateTime('+1 day');

        $this->assertInstanceOf(HeaderInterface::class, $header->setTimestamp($tomorrow));

        $this->assertSame($tomorrow, $header->getTimestamp());
    }

    public function testGetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderRetryAfter($now);

        $this->assertSame($now, $header->getTimestamp());
    }

    public function testGetFieldName()
    {
        $now = new \DateTime('now');

        $header = new HeaderRetryAfter($now);

        $this->assertSame('Retry-After', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $header = new HeaderRetryAfter($now);

        $expected = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertSame($expected->format(\DateTime::RFC822), $header->getFieldValue());
    }

    public function testToString()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderRetryAfter($now);

        $this->assertSame(\sprintf('Retry-After: %s', $now->format(\DateTime::RFC822)), (string) $header);
    }
}
