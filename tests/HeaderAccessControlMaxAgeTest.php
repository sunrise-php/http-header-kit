<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAccessControlMaxAge;

class HeaderAccessControlMaxAgeTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAccessControlMaxAge(-1);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAccessControlMaxAge(-1);

        $this->assertSame('Access-Control-Max-Age', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAccessControlMaxAge(-1);

        $this->assertSame('-1', $header->getFieldValue());
    }

    /**
     * @dataProvider validValueDataProvider
     */
    public function testValidValue(int $validValue)
    {
        $header = new HeaderAccessControlMaxAge($validValue);

        $this->assertSame((string) $validValue, $header->getFieldValue());
    }

    public function validValueDataProvider() : array
    {
        return [[-1], [1], [2]];
    }

    /**
     * @dataProvider invalidValueDataProvider
     */
    public function testInvalidValue(int $invalidValue)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(sprintf(
            'The value "%d" for the header "Access-Control-Max-Age" is not valid',
            $invalidValue
        ));

        new HeaderAccessControlMaxAge($invalidValue);
    }

    public function invalidValueDataProvider() : array
    {
        return [[-3], [-2], [0]];
    }

    public function testBuild()
    {
        $header = new HeaderAccessControlMaxAge(-1);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAccessControlMaxAge(-1);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
