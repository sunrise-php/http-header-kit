<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderEtag;
use Sunrise\Http\Header\HeaderInterface;

class HeaderEtagTest extends TestCase
{
	public function testConstructor()
	{
		$header = new HeaderEtag('value');

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testConstructorWithInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderEtag('"invalid value"');
	}

	public function testSetValue()
	{
		$header = new HeaderEtag('value');

		$this->assertInstanceOf(HeaderInterface::class, $header->setValue('new-value'));

		$this->assertEquals('new-value', $header->getValue());
	}

	public function testSetInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderEtag('value');

		$header->setValue('"invalid value"');
	}

	public function testGetValue()
	{
		$header = new HeaderEtag('value');

		$this->assertEquals('value', $header->getValue());
	}

	public function testGetFieldName()
	{
		$header = new HeaderEtag('value');

		$this->assertEquals('ETag', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$header = new HeaderEtag('value');

		$this->assertEquals('"value"', $header->getFieldValue());
	}

	public function testToString()
	{
		$header = new HeaderEtag('value');

		$this->assertEquals('ETag: "value"', (string) $header);
	}

	public function testSetToMessage()
	{
		$header = new HeaderEtag('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$header = new HeaderEtag('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
