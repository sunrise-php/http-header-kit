<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderExpires;

class HeaderExpiresTest extends TestCase
{
    public function testContracts()
    {
        $utc = new \DateTime('utc');
        $header = new HeaderExpires($utc);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $utc = new \DateTime('utc');
        $header = new HeaderExpires($utc);

        $this->assertSame('Expires', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $utc = new \DateTime('utc');
        $header = new HeaderExpires($utc);

        $this->assertSame($utc->format(\DateTime::RFC822), $header->getFieldValue());
    }

    public function testFieldValueWithMutableDateTime()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $utc = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderExpires($now);

        $this->assertSame($utc->format(\DateTime::RFC822), $header->getFieldValue());
        $this->assertSame('Europe/Moscow', $now->getTimezone()->getName());
    }

    public function testFieldValueWithImmutableDateTime()
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $utc = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));

        $header = new HeaderExpires($now);

        $this->assertSame($utc->format(\DateTimeImmutable::RFC822), $header->getFieldValue());
        $this->assertSame('Europe/Moscow', $now->getTimezone()->getName());
    }

    public function testBuild()
    {
        $now = new \DateTime('now');
        $header = new HeaderExpires($now);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $now = new \DateTime('now');
        $header = new HeaderExpires($now);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
