<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderWarning;
use Sunrise\Http\Header\HeaderInterface;

class HeaderWarningTest extends TestCase
{
    public function testConstants()
    {
        $this->assertSame(110, HeaderWarning::HTTP_WARNING_CODE_RESPONSE_IS_STALE);
        $this->assertSame(111, HeaderWarning::HTTP_WARNING_CODE_REVALIDATION_FAILED);
        $this->assertSame(112, HeaderWarning::HTTP_WARNING_CODE_DISCONNECTED_OPERATION);
        $this->assertSame(113, HeaderWarning::HTTP_WARNING_CODE_HEURISTIC_EXPIRATION);
        $this->assertSame(199, HeaderWarning::HTTP_WARNING_CODE_MISCELLANEOUS_WARNING);
        $this->assertSame(214, HeaderWarning::HTTP_WARNING_CODE_TRANSFORMATION_APPLIED);
        $this->assertSame(299, HeaderWarning::HTTP_WARNING_CODE_MISCELLANEOUS_PERSISTENT_WARNING);
    }

    public function testConstructorWithoutDate()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithDate()
    {
        $header = new HeaderWarning(199, 'agent', 'text', new \DateTime('now'));

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithSmallCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWarning(99, 'agent', 'text');
    }

    public function testConstructorWithBigCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWarning(1000, 'agent', 'text');
    }

    public function testConstructorWithInvalidAgent()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWarning(199, 'invalid agent', 'text');
    }

    public function testConstructorWithInvalidText()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWarning(199, 'agent', '"invalid text"');
    }

    public function testConstructorWithEmptyDate()
    {
        $header = new HeaderWarning(199, 'agent', 'text', null);

        $this->assertNull($header->getDate());
    }

    public function testSetCode()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertInstanceOf(HeaderInterface::class, $header->setCode(299));

        $this->assertSame(299, $header->getCode());
    }

    public function testSetSmallCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWarning(199, 'agent', 'text');

        $header->setCode(99);
    }

    public function testSetBigCode()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWarning(199, 'agent', 'text');

        $header->setCode(1000);
    }

    public function testSetAgent()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertInstanceOf(HeaderInterface::class, $header->setAgent('new-agent'));

        $this->assertSame('new-agent', $header->getAgent());
    }

    public function testSetInvalidAgent()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWarning(199, 'agent', 'text');

        $header->setAgent('invalid agent');
    }

    public function testSetText()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertInstanceOf(HeaderInterface::class, $header->setText('new-text'));

        $this->assertSame('new-text', $header->getText());
    }

    public function testSetInvalidText()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWarning(199, 'agent', 'text');

        $header->setText('"invalid text"');
    }

    public function testSetDate()
    {
        $now = new \DateTime('now');

        $later = new \DateTime('+1 hour');

        $header = new HeaderWarning(199, 'agent', 'text', $now);

        $this->assertInstanceOf(HeaderInterface::class, $header->setDate($later));

        $this->assertSame($later, $header->getDate());
    }

    public function testSetEmptyDate()
    {
        $now = new \DateTime('now');

        $header = new HeaderWarning(199, 'agent', 'text', $now);

        $this->assertInstanceOf(HeaderInterface::class, $header->setDate(null));

        $this->assertNull($header->getDate());
    }

    public function testGetCode()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame(199, $header->getCode());
    }

    public function testGetAgent()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('agent', $header->getAgent());
    }

    public function testGetText()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('text', $header->getText());
    }

    public function testGetDate()
    {
        $now = new \DateTime('now');

        $header = new HeaderWarning(199, 'agent', 'text', $now);

        $this->assertSame($now, $header->getDate());
    }

    public function testGetFieldName()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('Warning', $header->getFieldName());
    }

    public function testGetFieldValueWithoutDate()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('199 agent "text"', $header->getFieldValue());
    }

    public function testGetFieldValueWithDate()
    {
        $utc = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderWarning(199, 'agent', 'text', new \DateTime('now', new \DateTimeZone('Europe/Moscow')));

        $this->assertSame(
            \sprintf('199 agent "text" "%s"', $utc->format(\DateTime::RFC822)),
            $header->getFieldValue()
        );
    }

    public function testToStringWithoutDate()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('Warning: 199 agent "text"', (string) $header);
    }

    public function testToStringWithDate()
    {
        $utc = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderWarning(199, 'agent', 'text', new \DateTime('now', new \DateTimeZone('Europe/Moscow')));

        $this->assertSame(
            \sprintf('Warning: 199 agent "text" "%s"', $utc->format(\DateTime::RFC822)),
            (string) $header
        );
    }
}
