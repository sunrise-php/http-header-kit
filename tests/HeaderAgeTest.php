<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderAge;

class HeaderAgeTest extends TestCase
{
    public function testContracts()
    {
        $header = new HeaderAge(0);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderAge(0);

        $this->assertSame('Age', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderAge(0);

        $this->assertSame('0', $header->getFieldValue());
    }

    /**
     * @dataProvider validValueDataProvider
     */
    public function testValidValue(int $validValue)
    {
        $header = new HeaderAge($validValue);

        $this->assertEquals($validValue, $header->getFieldValue());
    }

    public function validValueDataProvider() : array
    {
        return [[0], [1], [2]];
    }

    /**
     * @dataProvider invalidValueDataProvider
     */
    public function testInvalidValue(int $invalidValue)
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(sprintf(
            'The value "%d" for the header "Age" is not valid',
            $invalidValue
        ));

        new HeaderAge($invalidValue);
    }

    public function invalidValueDataProvider() : array
    {
        return [[-3], [-2], [-1]];
    }

    public function testBuild()
    {
        $header = new HeaderAge(0);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderAge(0);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
