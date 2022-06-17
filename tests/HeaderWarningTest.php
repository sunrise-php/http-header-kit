<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderWarning;

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

    public function testContracts()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('Warning', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $this->assertSame('199 agent "text"', $header->getFieldValue());
    }

    public function testFieldValueWithDate()
    {
        $now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $utc = new \DateTime('now', new \DateTimeZone('UTC'));

        $header = new HeaderWarning(199, 'agent', 'text', $now);

        $this->assertSame(
            \sprintf(
                '199 agent "text" "%s"',
                $utc->format(\DateTime::RFC822)
            ),
            $header->getFieldValue()
        );

        // cannot be modified...
        $this->assertSame('Europe/Moscow', $now->getTimezone()->getName());
    }

    public function testCodeLessThat100()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The code "99" for the header "Warning" is not valid');

        new HeaderWarning(99, 'agent', 'text');
    }

    public function testCodeGreaterThat999()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The code "1000" for the header "Warning" is not valid');

        new HeaderWarning(1000, 'agent', 'text');
    }

    public function testEmptyAgent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "" for the header "Warning" is not valid');

        new HeaderWarning(199, '', 'text');
    }

    public function testInvalidAgent()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "@" for the header "Warning" is not valid');

        // isn't a token...
        new HeaderWarning(199, '@', 'text');
    }

    public function testEmptyText()
    {
        $header = new HeaderWarning(199, 'agent', '');

        $this->assertSame('199 agent ""', $header->getFieldValue());
    }

    public function testInvalidText()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The value ""text"" for the header "Warning" is not valid');

        // cannot contain quotes...
        new HeaderWarning(199, 'agent', '"text"');
    }

    public function testBuild()
    {
        $header = new HeaderWarning(199, 'agent', 'text');

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderWarning(199, 'agent', 'text');
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
