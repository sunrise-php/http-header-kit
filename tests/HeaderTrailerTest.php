<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderTrailer;
use Sunrise\Http\Header\HeaderInterface;

class HeaderTrailerTest extends TestCase
{
	public function testConstructor()
	{
		$header = new HeaderTrailer('value');

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testConstructorWithInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderTrailer('invalid value');
	}

	public function testSetValue()
	{
		$header = new HeaderTrailer('value');

		$this->assertInstanceOf(HeaderInterface::class, $header->setValue('new-value'));

		$this->assertEquals('new-value', $header->getValue());
	}

	public function testSetInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderTrailer('value');

		$header->setValue('invalid value');
	}

	public function testGetValue()
	{
		$header = new HeaderTrailer('value');

		$this->assertEquals('value', $header->getValue());
	}

	public function testGetFieldName()
	{
		$header = new HeaderTrailer('value');

		$this->assertEquals('Trailer', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$header = new HeaderTrailer('value');

		$this->assertEquals('value', $header->getFieldValue());
	}

	public function testToString()
	{
		$header = new HeaderTrailer('value');

		$this->assertEquals('Trailer: value', (string) $header);
	}

	public function testSetToMessage()
	{
		$header = new HeaderTrailer('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$header = new HeaderTrailer('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
