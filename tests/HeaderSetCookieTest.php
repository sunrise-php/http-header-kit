<?php declare(strict_types=1);

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderSetCookie;
use Sunrise\Http\Header\HeaderInterface;

class HeaderSetCookieTest extends TestCase
{
    public function testConstructor()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertInstanceOf(HeaderInterface::class, $header);
    }

    public function testConstructorWithEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderSetCookie('', 'value');
    }

    public function testConstructorWithInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderSetCookie('=invalid=', 'value');
    }

    public function testConstructorWithInvalidDomain()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderSetCookie('name', 'value', null, ['domain' => ';invalid;']);
    }

    public function testConstructorWithInvalidPath()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderSetCookie('name', 'value', null, ['path' => ';invalid;']);
    }

    public function testConstructorWithInvalidSamesite()
    {
        $this->expectException(\InvalidArgumentException::class);

        new HeaderSetCookie('name', 'value', null, ['samesite' => ';invalid;']);
    }

    public function testSetName()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertInstanceOf(HeaderInterface::class, $header->setName('newName'));

        $this->assertEquals('newName', $header->getName());
    }

    public function testSetEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderSetCookie('name', 'value');

        $header->setName('');
    }

    public function testSetInvalidName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderSetCookie('name', 'value');

        $header->setName('=invalid=');
    }

    public function testSetValue()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertInstanceOf(HeaderInterface::class, $header->setValue('newValue'));

        $this->assertEquals('newValue', $header->getValue());
    }

    public function testSetExpires()
    {
        $now = new \DateTime('now');

        $tomorrow = new \DateTime('+1 day');

        $header = new HeaderSetCookie('name', 'value', $now);

        $this->assertInstanceOf(HeaderInterface::class, $header->setExpires($tomorrow));

        $this->assertEquals($tomorrow, $header->getExpires());
    }

    public function testResetExpires()
    {
        $now = new \DateTime('now');

        $header = new HeaderSetCookie('name', 'value', $now);

        $header->setExpires(null);

        $this->assertEquals(null, $header->getExpires());
    }

    public function testSetDomain()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['domain' => 'domain.net']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setDomain('new.domain.net'));

        $this->assertEquals('new.domain.net', $header->getDomain());
    }

    public function testSetInvalidDomain()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderSetCookie('name', 'value');

        $header->setDomain(';invalid;');
    }

    public function testResetDomain()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['domain' => 'domain.net']);

        $header->setDomain(null);

        $this->assertEquals(null, $header->getDomain());
    }

    public function testSetPath()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['path' => '/path/']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setPath('/new/path/'));

        $this->assertEquals('/new/path/', $header->getPath());
    }

    public function testSetInvalidPath()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderSetCookie('name', 'value');

        $header->setPath(';invalid;');
    }

    public function testResetPath()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['path' => '/path/']);

        $header->setPath(null);

        $this->assertEquals(null, $header->getPath());
    }

    public function testSetSecure()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['secure' => true]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setSecure(false));

        $this->assertEquals(false, $header->getSecure());
    }

    public function testResetSecure()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['secure' => true]);

        $header->setSecure(null);

        $this->assertEquals(null, $header->getSecure());
    }

    public function testSetHttpOnly()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['httponly' => true]);

        $this->assertInstanceOf(HeaderInterface::class, $header->setHttpOnly(false));

        $this->assertEquals(false, $header->getHttpOnly());
    }

    public function testResetHttpOnly()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['httponly' => true]);

        $header->setHttpOnly(null);

        $this->assertEquals(null, $header->getHttpOnly());
    }

    public function testSetSameSite()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['samesite' => 'lax']);

        $this->assertInstanceOf(HeaderInterface::class, $header->setSameSite('strict'));

        $this->assertEquals('strict', $header->getSameSite());
    }

    public function testSetInvalidSameSite()
    {
        $this->expectException(\InvalidArgumentException::class);

        $header = new HeaderSetCookie('name', 'value');

        $header->setSameSite(';invalid;');
    }

    public function testResetSameSite()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['samesite' => 'lax']);

        $header->setSameSite(null);

        $this->assertEquals(null, $header->getSameSite());
    }

    public function testGetName()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertEquals('name', $header->getName());
    }

    public function testGetValue()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertEquals('value', $header->getValue());
    }

    public function testGetExpires()
    {
        $now = new \DateTime('now');

        $header = new HeaderSetCookie('name', 'value', $now);

        $this->assertEquals($now, $header->getExpires());
    }

    public function testGetDomain()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['domain' => 'domain.net']);

        $this->assertEquals('domain.net', $header->getDomain());
    }

    public function testGetPath()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['path' => '/path/']);

        $this->assertEquals('/path/', $header->getPath());
    }

    public function testGetSecure()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['secure' => true]);

        $this->assertEquals(true, $header->getSecure());
    }

    public function testGetHttpOnly()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['httponly' => true]);

        $this->assertEquals(true, $header->getHttpOnly());
    }

    public function testGetSameSite()
    {
        $header = new HeaderSetCookie('name', 'value', null, ['samesite' => 'lax']);

        $this->assertEquals('lax', $header->getSameSite());
    }

    public function testGetFieldName()
    {
        $header = new HeaderSetCookie('name', 'value');

        $this->assertEquals('Set-Cookie', $header->getFieldName());
    }

    public function testGetFieldValue()
    {
        $now = new \DateTime('now');

        $header = new HeaderSetCookie('name', 'value', $now, [
            'domain' => 'domain.net',
            'path' => '/path/',
            'secure' => false,
            'httponly' => false,
            'samesite' => 'strict',
        ]);

        $expected = 'name=value; Expires=' . $now->format(\DateTime::RFC822) .
                    '; Max-Age=0; Domain=domain.net; Path=/path/; SameSite=strict';

        $this->assertEquals($expected, $header->getFieldValue());
    }

    public function testToString()
    {
        $utc = new \DateTime('+30 seconds', new \DateTimeZone('UTC'));

        $local = new \DateTime('+30 seconds', new \DateTimeZone('Europe/Moscow'));

        $header = new HeaderSetCookie('name', 'value', $local, [
            'domain' => 'domain.net',
            'path' => '/path/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'strict',
        ]);

        $expected = 'Set-Cookie: name=value; Expires=' . $utc->format(\DateTime::RFC822) .
                    '; Max-Age=30; Domain=domain.net; Path=/path/; Secure; HttpOnly; SameSite=strict';

        $this->assertEquals($expected, (string) $header);
    }

    public function testSetToMessage()
    {
        $header = new HeaderSetCookie('name', 'value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->setToMessage($message);

        $this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }

    public function testAddToMessage()
    {
        $header = new HeaderSetCookie('name', 'value');

        $message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
        $message = $message->withHeader($header->getFieldName(), 'foo bar baz');

        $message = $header->addToMessage($message);

        $this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
    }
}
