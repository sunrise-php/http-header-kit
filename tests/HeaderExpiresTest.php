<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderExpires;
use Sunrise\Http\Header\HeaderInterface;

class HeaderExpiresTest extends TestCase
{
    public function testConstructor()
    {
        $now = new \DateTime('now');

        $header = new HeaderExpires($now);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testSetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderExpires($now);

        $tomorrow = new \DateTime('+1 day');

        $this->assertInstanceOf(HeaderInterface::class, $header->setTimestamp($tomorrow));

        $this->assertSame($tomorrow, $header->getTimestamp());
    }

    public function testGetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderExpires($now);

        $this->assertSame($now, $header->getTimestamp());
    }

    public function testGetFieldName()
    {
        $now = new \DateTime('now');

        $header = new HeaderExpires($now);

        $this->assertSame('Expires', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $header = new HeaderExpires($now);

        $expected = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertSame($expected->format(\DateTime::RFC822), $header->getFieldValue());
    }

    public function testToString()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderExpires($now);

        $this->assertSame(\sprintf('Expires: %s', $now->format(\DateTime::RFC822)), (string) $header);
    }
}
