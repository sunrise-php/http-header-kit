<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderSunset;
use Sunrise\Http\Header\HeaderInterface;

class HeaderSunsetTest extends TestCase
{
    public function testConstructor()
    {
        $now = new \DateTime('now');

        $header = new HeaderSunset($now);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testSetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderSunset($now);

        $tomorrow = new \DateTime('+1 day');

        $this->assertInstanceOf(HeaderInterface::class, $header->setTimestamp($tomorrow));

        $this->assertSame($tomorrow, $header->getTimestamp());
    }

    public function testGetTimestamp()
    {
        $now = new \DateTime('now');

        $header = new HeaderSunset($now);

        $this->assertSame($now, $header->getTimestamp());
    }

    public function testGetFieldName()
    {
        $now = new \DateTime('now');

        $header = new HeaderSunset($now);

        $this->assertSame('Sunset', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

        $header = new HeaderSunset($now);

        $expected = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->assertSame($expected->format(\DateTime::RFC822), $header->getFieldValue());
    }

    public function testToString()
    {
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderSunset($now);

        $this->assertSame(\sprintf('Sunset: %s', $now->format(\DateTime::RFC822)), (string) $header);
    }
}
