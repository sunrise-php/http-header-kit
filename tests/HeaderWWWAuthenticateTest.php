<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderWWWAuthenticate;
use Sunrise\Http\Header\HeaderInterface;

class HeaderWWWAuthenticateTest extends TestCase
{
    public function testConstants()
    {
        $this->assertEquals('Basic', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BASIC);
        $this->assertEquals('Bearer', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BEARER);
        $this->assertEquals('Digest', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_DIGEST);
        $this->assertEquals('HOBA', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_HOBA);
        $this->assertEquals('Mutual', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_MUTUAL);
        $this->assertEquals('Negotiate', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_NEGOTIATE);
        $this->assertEquals('OAuth', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_OAUTH);
        $this->assertEquals('SCRAM-SHA-1', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_1);
        $this->assertEquals('SCRAM-SHA-256', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_256);
        $this->assertEquals('vapid', HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_VAPID);
    }

    public function testConstructor()
    {
        $header = new HeaderWWWAuthenticate('scheme');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWWWAuthenticate('invalid scheme');
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWWWAuthenticate('scheme', ['parameter-name=' => 'parameter-value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderWWWAuthenticate('scheme', ['parameter-name' => '"parameter-value"']);
    }

    public function testSetScheme()
    {
        $header = new HeaderWWWAuthenticate('scheme');

        $this->assertInstanceOf(HeaderInterface::class, $header->setScheme('overwritten-scheme'));

        $this->assertEquals('overwritten-scheme', $header->getScheme());
    }

    public function testSetInvalidScheme()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWWWAuthenticate('scheme');

        $header->setScheme('invalid scheme');
    }

    public function testSetParameter()
    {
        $header = new HeaderWWWAuthenticate('scheme', ['parameter-name' => 'parameter-value']);

        $this->assertInstanceOf(
            HeaderInterface::class,
            $header->setParameter('parameter-name', 'overwritten-parameter-value')
        );

        $this->assertEquals(['parameter-name' => 'overwritten-parameter-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $header->setParameter('parameter-name-1', 'overwritten-parameter-value-1');
        $header->setParameter('parameter-name-2', 'overwritten-parameter-value-2');

        $this->assertEquals([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ], $header->getParameters());
    }

    public function testSetParameterWithInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWWWAuthenticate('scheme');

        $header->setParameter('parameter-name=', 'parameter-value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWWWAuthenticate('scheme');

        $header->setParameter('parameter-name', '"parameter-value"');
    }

    public function testSetParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setParameters([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ]));

        $this->assertEquals([
            'parameter-name-1' => 'overwritten-parameter-value-1',
            'parameter-name-2' => 'overwritten-parameter-value-2',
        ], $header->getParameters());
    }

    public function testSetParametersWithParameterThatContainsInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWWWAuthenticate('scheme');

        $header->setParameters(['invalid name' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderWWWAuthenticate('scheme');

        $header->setParameters(['name' => '"invalid value"']);
    }

    public function testGetScheme()
    {
        $header = new HeaderWWWAuthenticate('scheme');

        $this->assertEquals('scheme', $header->getScheme());
    }

    public function testGetParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme', ['parameter-name' => 'parameter-value']);

        $this->assertEquals(['parameter-name' => 'parameter-value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme', [
            'parameter-name-1' => 'parameter-value-1',
        ]);

        $header->setParameters([
            'parameter-name-2' => 'parameter-value-2',
        ]);

        $header->setParameter('parameter-name-3', 'parameter-value-3');

        $this->assertInstanceOf(HeaderInterface::class, $header->clearParameters());

        $this->assertEquals([], $header->getParameters());
    }

    public function testGetFieldName()
    {
        $header = new HeaderWWWAuthenticate('scheme');

        $this->assertEquals('WWW-Authenticate', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $header = new HeaderWWWAuthenticate('scheme', ['parameter-name' => 'parameter-value']);

        $this->assertEquals('scheme parameter-name="parameter-value"', $header->getFieldValue());
    }

    public function testToStringWithoutParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme');

        $this->assertEquals('WWW-Authenticate: scheme', (string) $header);
    }

    public function testToStringWithParameterWithoutValue()
    {
        $header = new HeaderWWWAuthenticate('scheme', ['parameter-name' => '']);

        $this->assertEquals('WWW-Authenticate: scheme parameter-name=""', (string) $header);
    }

    public function testToStringWithOneParameter()
    {
        $header = new HeaderWWWAuthenticate('scheme', ['parameter-name' => 'parameter-value']);

        $this->assertEquals('WWW-Authenticate: scheme parameter-name="parameter-value"', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $header = new HeaderWWWAuthenticate('scheme', [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
            'parameter-name-3' => 'parameter-value-3',
        ]);

        $expected = 'WWW-Authenticate: scheme parameter-name-1="parameter-value-1", ' .
                    'parameter-name-2="parameter-value-2", parameter-name-3="parameter-value-3"';

        $this->assertEquals($expected, (string) $header);
    }
}
