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
use Psr\Http\Message\UriInterface;

/**
 * HeaderLink
 *
 * @link https://tools.ietf.org/html/rfc5988
 */
class HeaderLink extends AbstractHeader implements HeaderInterface
{

	/**
	 * The link URI
	 *
	 * @var UriInterface
	 */
	protected $uri;

	/**
	 * The link parameters
	 *
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * Constructor of the class
	 *
	 * @param UriInterface $uri
	 * @param array $parameters
	 */
	public function __construct(UriInterface $uri, array $parameters = [])
	{
		$this->setUri($uri);
		$this->setParameters($parameters);
	}

	/**
	 * Sets the link URI
	 *
	 * @param UriInterface $uri
	 *
	 * @return self
	 */
	public function setUri(UriInterface $uri) : self
	{
		$this->uri = $uri;

		return $this;
	}

	/**
	 * Sets the link parameter
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
	 * Sets the link parameters
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
	 * Gets the link URI
	 *
	 * @return UriInterface
	 */
	public function getUri() : UriInterface
	{
		return $this->uri;
	}

	/**
	 * Gets the link parameters
	 *
	 * @return array
	 */
	public function getParameters() : array
	{
		return $this->parameters;
	}

	/**
	 * Clears the link parameters
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
		return 'Link';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		$r = \sprintf('<%s>', (string) $this->getUri());

		foreach ($this->getParameters() as $name => $value)
		{
			$r .= \sprintf('; %s="%s"', $name, $value);
		}

		return $r;
	}
}
