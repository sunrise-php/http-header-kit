<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Http\Header\HeaderWWWAuthenticate;

class HeaderWWWAuthenticateTest extends TestCase
{
    public function testConstants()
    {
        $this->assertSame('Basic', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BASIC);
        $this->assertSame('Bearer', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BEARER);
        $this->assertSame('Digest', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_DIGEST);
        $this->assertSame('HOBA', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_HOBA);
        $this->assertSame('Mutual', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_MUTUAL);
        $this->assertSame('Negotiate', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_NEGOTIATE);
        $this->assertSame('OAuth', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_OAUTH);
        $this->assertSame('SCRAM-SHA-1', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_1);
        $this->assertSame('SCRAM-SHA-256', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_256);
        $this->assertSame('vapid', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_VAPID);
    }

    public function testContracts()
    {
        $header = new HeaderWWWAuthenticate('foo');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testFieldName()
    {
        $header = new HeaderWWWAuthenticate('foo');

        $this->assertSame('WWW-Authenticate', $header->getFieldName());
    }

    public function testFieldValue()
    {
        $header = new HeaderWWWAuthenticate('foo');

        $this->assertSame('foo', $header->getFieldValue());
    }

    public function testParameterWithEmptyValue()
    {
        $header = new HeaderWWWAuthenticate('foo', [
            'bar' => '',
        ]);

        $this->assertSame('foo bar=""', $header->getFieldValue());
    }

    public function testParameterWithToken()
    {
        $header = new HeaderWWWAuthenticate('foo', [
            'bar' => 'token',
        ]);

        $this->assertSame('foo bar="token"', $header->getFieldValue());
    }

    public function testParameterWithQuotedString()
    {
        $header = new HeaderWWWAuthenticate('foo', [
            'bar' => 'quoted string',
        ]);

        $this->assertSame('foo bar="quoted string"', $header->getFieldValue());
    }

    public function testParameterWithInteger()
    {
        $header = new HeaderWWWAuthenticate('foo', [
            'bar' => 1,
        ]);

        $this->assertSame('foo bar="1"', $header->getFieldValue());
    }

    public function testSeveralParameters()
    {
        $header = new HeaderWWWAuthenticate('foo', [
            'bar' => '',
            'baz' => 'token',
            'bat' => 'quoted string',
            'qux' => 1,
        ]);

        $this->assertSame('foo bar="", baz="token", bat="quoted string", qux="1"', $header->getFieldValue());
    }

    public function testEmptyScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWWWAuthenticate('');
    }

    public function testInvalidScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        // isn't a token...
        new HeaderWWWAuthenticate('@');
    }

    public function testInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "invalid name" for the header "WWW-Authenticate" is not valid'
        );

        // cannot contain spaces...
        new HeaderWWWAuthenticate('foo', ['invalid name' => 'value']);
    }

    public function testInvalidParameterNameType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-name "<integer>" for the header "WWW-Authenticate" is not valid'
        );

        // cannot contain spaces...
        new HeaderWWWAuthenticate('foo', [0 => 'value']);
    }

    public function testInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value ""invalid value"" for the header "WWW-Authenticate" is not valid'
        );

        // cannot contain quotes...
        new HeaderWWWAuthenticate('foo', ['name' => '"invalid value"']);
    }

    public function testInvalidParameterValueType()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage(
            'The parameter-value "<array>" for the header "WWW-Authenticate" is not valid'
        );

        // cannot contain quotes...
        new HeaderWWWAuthenticate('foo', ['name' => []]);
    }

    public function testBuild()
    {
        $header = new HeaderWWWAuthenticate('foo', ['bar' => 'baz']);

        $expected = \sprintf('%s: %s', $header->getFieldName(), $header->getFieldValue());

        $this->assertSame($expected, $header->__toString());
    }

    public function testIterator()
    {
        $header = new HeaderWWWAuthenticate('foo', ['bar' => 'baz']);
        $iterator = $header->getIterator();

        $iterator->rewind();
        $this->assertSame($header->getFieldName(), $iterator->current());

        $iterator->next();
        $this->assertSame($header->getFieldValue(), $iterator->current());

        $iterator->next();
        $this->assertFalse($iterator->valid());
    }
}
