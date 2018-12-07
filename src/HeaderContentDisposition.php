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
 * HeaderContentDisposition
 *
 * @link https://tools.ietf.org/html/rfc2616#section-19.5.1
 */
class HeaderContentDisposition extends AbstractHeader implements HeaderInterface
{

	/**
	 * The content disposition-type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * The content disposition-type parameters
	 *
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * Constructor of the class
	 *
	 * @param string $type
	 * @param array $parameters
	 */
	public function __construct(string $type, array $parameters = [])
	{
		$this->setType($type);
		$this->setParameters($parameters);
	}

	/**
	 * Sets the content disposition-type
	 *
	 * @param string $type
	 *
	 * @return self
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setType(string $type) : self
	{
		if (! \preg_match(HeaderInterface::RFC7230_TOKEN, $type))
		{
			throw new \InvalidArgumentException(\sprintf('The header field "%s: %s" is not valid', $this->getFieldName(), $type));
		}

		$this->type = $type;

		return $this;
	}

	/**
	 * Sets the content disposition-type parameter
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return self
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setParameter(string $name, string $value) : self
	{
		if (! \preg_match(HeaderInterface::RFC7230_TOKEN, $name))
		{
			throw new \InvalidArgumentException(\sprintf('The parameter-name "%s" for the header "%s" is not valid', $name, $this->getFieldName()));
		}
		else if (! \preg_match(HeaderInterface::RFC7230_QUOTED_STRING, $value))
		{
			throw new \InvalidArgumentException(\sprintf('The parameter-value "%s" for the header "%s" is not valid', $value, $this->getFieldName()));
		}

		$this->parameters[$name] = $value;

		return $this;
	}

	/**
	 * Sets the content disposition-type parameters
	 *
	 * @param array $parameters
	 *
	 * @return self
	 */
	public function setParameters(array $parameters) : self
	{
		foreach ($parameters as $name => $value)
		{
			$this->setParameter($name, $value);
		}

		return $this;
	}

	/**
	 * Gets the content disposition-type
	 *
	 * @return string
	 */
	public function getType() : string
	{
		return $this->type;
	}

	/**
	 * Gets the content disposition-type parameters
	 *
	 * @return array
	 */
	public function getParameters() : array
	{
		return $this->parameters;
	}

	/**
	 * Clears the content disposition-type parameters
	 *
	 * @return self
	 */
	public function clearParameters() : self
	{
		$this->parameters = [];

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldName() : string
	{
		return 'Content-Disposition';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		$r = $this->getType();

		foreach ($this->getParameters() as $name => $value)
		{
			$r .= \sprintf('; %s="%s"', $name, $value);
		}

		return $r;
	}
}
