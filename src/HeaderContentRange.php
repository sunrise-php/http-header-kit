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
 * HeaderContentRange
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.16
 */
class HeaderContentRange extends AbstractHeader implements HeaderInterface
{

	/**
	 * The "first-byte-pos" value of the content range
	 *
	 * @var int
	 */
	protected $firstBytePosition;

	/**
	 * The "last-byte-pos" value of the content range
	 *
	 * @var int
	 */
	protected $lastBytePosition;

	/**
	 * The "instance-length" value of the content range
	 *
	 * @var int
	 */
	protected $instanceLength;

	/**
	 * Constructor of the class
	 *
	 * @param int $firstBytePosition
	 * @param int $lastBytePosition
	 * @param int $instanceLength
	 */
	public function __construct(int $firstBytePosition, int $lastBytePosition, int $instanceLength)
	{
		$this->setRange($firstBytePosition, $lastBytePosition, $instanceLength);
	}

	/**
	 * Sets the content range values
	 *
	 * @param int $firstBytePosition
	 * @param int $lastBytePosition
	 * @param int $instanceLength
	 *
	 * @return self
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setRange(int $firstBytePosition, int $lastBytePosition, int $instanceLength) : self
	{
		if (! ($firstBytePosition <= $lastBytePosition))
		{
			throw new \InvalidArgumentException('The "first-byte-pos" value of the content range must be less than or equal to the "last-byte-pos" value');
		}
		else if (! ($lastBytePosition < $instanceLength))
		{
			throw new \InvalidArgumentException('The "last-byte-pos" value of the content range must be less than the "instance-length" value');
		}

		$this->firstBytePosition = $firstBytePosition;

		$this->lastBytePosition = $lastBytePosition;

		$this->instanceLength = $instanceLength;

		return $this;
	}

	/**
	 * Gets the "first-byte-pos" value of the content range
	 *
	 * @return int
	 */
	public function getFirstBytePosition() : int
	{
		return $this->firstBytePosition;
	}

	/**
	 * Gets the "last-byte-pos" value of the content range
	 *
	 * @return int
	 */
	public function getLastBytePosition() : int
	{
		return $this->lastBytePosition;
	}

	/**
	 * Gets the "instance-length" value of the content range
	 *
	 * @return int
	 */
	public function getInstanceLength() : int
	{
		return $this->instanceLength;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldName() : string
	{
		return 'Content-Range';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		return \sprintf('bytes %d-%d/%d',
			$this->getFirstBytePosition(),
			$this->getLastBytePosition(),
			$this->getInstanceLength()
		);
	}
}
