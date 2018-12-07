<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAge;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAgeTest extends TestCase
{
	public function testConstructor()
	{
		$header = new HeaderAge(0);

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testConstructorWithInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderAge(-1);
	}

	public function testSetValue()
	{
		$header = new HeaderAge(0);

		$this->assertInstanceOf(HeaderInterface::class, $header->setValue(1));

		$this->assertEquals(1, $header->getValue());
	}

	public function testSetInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderAge(0);

		$header->setValue(-1);
	}

	public function testGetValue()
	{
		$header = new HeaderAge(0);

		$this->assertEquals(0, $header->getValue());
	}

	public function testGetFieldName()
	{
		$header = new HeaderAge(0);

		$this->assertEquals('Age', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$header = new HeaderAge(0);

		$this->assertEquals('0', $header->getFieldValue());
	}

	public function testToString()
	{
		$header = new HeaderAge(0);

		$this->assertEquals('Age: 0', (string) $header);
	}

	public function testSetToMessage()
	{
		$header = new HeaderAge(0);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$header = new HeaderAge(0);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
