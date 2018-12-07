<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderExpires;
use Sunrise\Http\Header\HeaderInterface;

class HeaderExpiresTest extends TestCase
{
	public function testConstructor()
	{
		$now = new \DateTime('now');

		$header = new HeaderExpires($now);

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testSetTimestamp()
	{
		$now = new \DateTime('now');

		$header = new HeaderExpires($now);

		$tomorrow = new \DateTime('+1 day');

		$this->assertInstanceOf(HeaderInterface::class, $header->setTimestamp($tomorrow));

		$this->assertEquals($tomorrow, $header->getTimestamp());
	}

	public function testGetTimestamp()
	{
		$now = new \DateTime('now');

		$header = new HeaderExpires($now);

		$this->assertEquals($now, $header->getTimestamp());
	}

	public function testGetFieldName()
	{
		$now = new \DateTime('now');

		$header = new HeaderExpires($now);

		$this->assertEquals('Expires', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$now = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));

		$header = new HeaderExpires($now);

		$expected = new \DateTime('now', new \DateTimeZone('UTC'));

		$this->assertEquals($expected->format(\DateTime::RFC822), $header->getFieldValue());
	}

	public function testToString()
	{
		$now = new \DateTime('now', new \DateTimeZone('UTC'));

		$header = new HeaderExpires($now);

		$this->assertEquals(\sprintf('Expires: %s', $now->format(\DateTime::RFC822)), (string) $header);
	}

	public function testSetToMessage()
	{
		$now = new \DateTime('now');
		$header = new HeaderExpires($now);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$now = new \DateTime('now');
		$header = new HeaderExpires($now);

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
