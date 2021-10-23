<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderLink;
use Sunrise\Http\Header\HeaderInterface;
use Sunrise\Uri\Uri;

class HeaderLinkTest extends TestCase
{
    public function testConstructor()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithInvalidParameterName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $uri = new Uri('/');

        new HeaderLink($uri, ['parameter-name=' => 'parameter-value']);
    }

    public function testConstructorWithInvalidParameterValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $uri = new Uri('/');

        new HeaderLink($uri, ['parameter-name' => '"parameter-value"']);
    }

    public function testSetUri()
    {
        $uri1 = new Uri('/1');

        $uri2 = new Uri('/2');

        $header = new HeaderLink($uri1);

        $this->assertInstanceOf(HeaderInterface::class, $header->setUri($uri2));

        $this->assertEquals($uri2, $header->getUri());
    }

    public function testSetParameter()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, ['parameter-name' => 'parameter-value']);

        $this->assertInstanceOf(
            HeaderInterface::class,
            $header->setParameter('parameter-name', 'overwritten-parameter-value')
        );

        $this->assertEquals(['parameter-name' => 'overwritten-parameter-value'], $header->getParameters());
    }

    public function testSetSeveralParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
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

        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $header->setParameter('parameter-name=', 'parameter-value');
    }

    public function testSetParameterWithInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $header->setParameter('parameter-name', '"parameter-value"');
    }

    public function testSetParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
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

        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $header->setParameters(['invalid name' => 'value']);
    }

    public function testSetParametersWithParameterThatContainsInvalidValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $header->setParameters(['name' => '"invalid value"']);
    }

    public function testGetUri()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $this->assertEquals($uri, $header->getUri());
    }

    public function testGetParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, ['parameter-name' => 'parameter-value']);

        $this->assertEquals(['parameter-name' => 'parameter-value'], $header->getParameters());
    }

    public function testClearParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
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
        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $this->assertEquals('Link', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, ['parameter-name' => 'parameter-value']);

        $this->assertEquals('</>; parameter-name="parameter-value"', $header->getFieldValue());
    }

    public function testToStringWithoutParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri);

        $this->assertEquals('Link: </>', (string) $header);
    }

    public function testToStringWithParameterWithoutValue()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, ['parameter-name' => '']);

        $this->assertEquals('Link: </>; parameter-name=""', (string) $header);
    }

    public function testToStringWithOneParameter()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, ['parameter-name' => 'parameter-value']);

        $this->assertEquals('Link: </>; parameter-name="parameter-value"', (string) $header);
    }

    public function testToStringWithSeveralParameters()
    {
        $uri = new Uri('/');

        $header = new HeaderLink($uri, [
            'parameter-name-1' => 'parameter-value-1',
            'parameter-name-2' => 'parameter-value-2',
            'parameter-name-3' => 'parameter-value-3',
        ]);

        $expected = 'Link: </>; parameter-name-1="parameter-value-1"; '.
                    'parameter-name-2="parameter-value-2"; parameter-name-3="parameter-value-3"';

        $this->assertEquals($expected, (string) $header);
    }
}
