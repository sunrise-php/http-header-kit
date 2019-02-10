<?php declare(strict_types=1);

/**
 * It's free open-source software released under the MIT License.
 *
 * @author Anatoly Fenric <anatoly@fenric.ru>
 * @copyright Copyright (c) 2018, Anatoly Fenric
 * @license https://github.com/sunrise-php/http-header-kit/blob/master/LICENSE
 * @link https://github.com/sunrise-php/http-header-kit
 */

namespace Sunrise\Http\Header;

/**
 * Import classes
 */
use Psr\Http\Message\MessageInterface;

/**
 * AbstractHeader
 */
abstract class AbstractHeader implements HeaderInterface
{

	/**
	 * {@inheritDoc}
	 */
	public function setToMessage(MessageInterface $message) : MessageInterface
	{
		return $message->withHeader(
			$this->getFieldName(),
			$this->getFieldValue()
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function addToMessage(MessageInterface $message) : MessageInterface
	{
		return $message->withAddedHeader(
			$this->getFieldName(),
			$this->getFieldValue()
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function __toString()
	{
		return \sprintf('%s: %s',
			$this->getFieldName(),
			$this->getFieldValue()
		);
	}
}
