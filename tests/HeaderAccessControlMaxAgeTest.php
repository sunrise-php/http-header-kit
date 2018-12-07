<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlMaxAge;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlMaxAgeTest extends TestCase
{
	public function testConstructor()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testConstructorWithInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderAccessControlMaxAge(0);
	}

	public function testSetValue()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertInstanceOf(HeaderInterface::class, $header->setValue(-1));

		$this->assertEquals(-1, $header->getValue());
	}

	public function testSetInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderAccessControlMaxAge(86400);

		$header->setValue(0);
	}

	public function testGetValue()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertEquals(86400, $header->getValue());
	}

	public function testGetFieldName()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertEquals('Access-Control-Max-Age', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertEquals('86400', $header->getFieldValue());
	}

	public function testToString()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$this->assertEquals('Access-Control-Max-Age: 86400', (string) $header);
	}

	public function testSetToMessage()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$header = new HeaderAccessControlMaxAge(86400);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
