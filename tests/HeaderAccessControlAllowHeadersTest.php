<?php

namespace Sunrise\Http\Header\Tests;

use PHPUnit\Framework\TestCase;
use Sunrise\Http\Header\HeaderAccessControlAllowHeaders;
use Sunrise\Http\Header\HeaderInterface;

class HeaderAccessControlAllowHeadersTest extends TestCase
{
	public function testConstructor()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertInstanceOf(HeaderInterface::class, $header);
	}

	public function testConstructorWithEmptyValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderAccessControlAllowHeaders('');
	}

	public function testConstructorWithInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		new HeaderAccessControlAllowHeaders('invalid value');
	}

	public function testSetValue()
	{
		$header = new HeaderAccessControlAllowHeaders('value-first');

		$this->assertInstanceOf(HeaderInterface::class, $header->setValue('value-second'));

		$this->assertEquals([
			'value-first',
			'value-second',
		], $header->getValue());
	}

	public function testSetSeveralValues()
	{
		$header = new HeaderAccessControlAllowHeaders('value-first', 'value-second');

		$header->setValue('value-third', 'value-fourth');

		$this->assertEquals([
			'value-first',
			'value-second',
			'value-third',
			'value-fourth',
		], $header->getValue());
	}

	public function testSetEmptyValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderAccessControlAllowHeaders('value');

		$header->setValue('');
	}

	public function testSetInvalidValue()
	{
		$this->expectException(\InvalidArgumentException::class);

		$header = new HeaderAccessControlAllowHeaders('value');

		$header->setValue('invalid value');
	}

	public function testGetValue()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertEquals(['value'], $header->getValue());
	}

	public function testResetValue()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertInstanceOf(HeaderInterface::class, $header->resetValue());

		$this->assertEquals([], $header->getValue());
	}

	public function testGetFieldName()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertEquals('Access-Control-Allow-Headers', $header->getFieldName());
	}

	public function testGetFieldValue()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertEquals('value', $header->getFieldValue());
	}

	public function testToStringWithOneValue()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$this->assertEquals('Access-Control-Allow-Headers: value', (string) $header);
	}

	public function testToStringWithSeveralValues()
	{
		$header = new HeaderAccessControlAllowHeaders('value-first', 'value-second', 'value-third');

		$this->assertEquals('Access-Control-Allow-Headers: value-first, value-second, value-third', (string) $header);
	}

	public function testSetToMessage()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->setToMessage($message);

		$this->assertEquals([$header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}

	public function testAddToMessage()
	{
		$header = new HeaderAccessControlAllowHeaders('value');

		$message = (new \Sunrise\Http\Message\ResponseFactory)->createResponse();
		$message = $message->withHeader($header->getFieldName(), 'foo bar baz');

		$message = $header->addToMessage($message);

		$this->assertEquals(['foo bar baz', $header->getFieldValue()], $message->getHeader($header->getFieldName()));
	}
}
