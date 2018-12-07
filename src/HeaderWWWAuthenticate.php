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
 * HeaderWWWAuthenticate
 *
 * @link https://tools.ietf.org/html/rfc7235#section-4.1
 */
class HeaderWWWAuthenticate extends AbstractHeader implements HeaderInterface
{

	/**
	 * HTTP Authentication Schemes
	 *
	 * @link https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
	 */
	public const HTTP_AUTHENTICATE_SCHEME_BASIC         = 'Basic';
	public const HTTP_AUTHENTICATE_SCHEME_BEARER        = 'Bearer';
	public const HTTP_AUTHENTICATE_SCHEME_DIGEST        = 'Digest';
	public const HTTP_AUTHENTICATE_SCHEME_HOBA          = 'HOBA';
	public const HTTP_AUTHENTICATE_SCHEME_MUTUAL        = 'Mutual';
	public const HTTP_AUTHENTICATE_SCHEME_NEGOTIATE     = 'Negotiate';
	public const HTTP_AUTHENTICATE_SCHEME_OAUTH         = 'OAuth';
	public const HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_1   = 'SCRAM-SHA-1';
	public const HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_256 = 'SCRAM-SHA-256';
	public const HTTP_AUTHENTICATE_SCHEME_VAPID         = 'vapid';

	/**
	 * The authentication scheme
	 *
	 * @var string
	 */
	protected $scheme;

	/**
	 * The authentication parameters
	 *
	 * @var array
	 */
	protected $parameters = [];

	/**
	 * Constructor of the class
	 *
	 * @param string $scheme
	 * @param array $parameters
	 */
	public function __construct(string $scheme, array $parameters = [])
	{
		$this->setScheme($scheme);
		$this->setParameters($parameters);
	}

	/**
	 * Sets the authentication scheme
	 *
	 * @param string $scheme
	 *
	 * @return self
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setScheme(string $scheme) : self
	{
		if (! \preg_match(HeaderInterface::RFC7230_TOKEN, $scheme))
		{
			throw new \InvalidArgumentException(\sprintf('The header field "%s: %s" is not valid', $this->getFieldName(), $scheme));
		}

		$this->scheme = $scheme;

		return $this;
	}

	/**
	 * Sets the authentication parameter
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
	 * Sets the authentication parameters
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
	 * Gets the authentication scheme
	 *
	 * @return string
	 */
	public function getScheme() : string
	{
		return $this->scheme;
	}

	/**
	 * Gets the authentication parameters
	 *
	 * @return array
	 */
	public function getParameters() : array
	{
		return $this->parameters;
	}

	/**
	 * Clears the authentication parameters
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
		return 'WWW-Authenticate';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		$r = $this->getScheme();

		$challenge = [];

		foreach ($this->getParameters() as $name => $value)
		{
			$challenge[] = \sprintf(' %s="%s"', $name, $value);
		}

		if (! empty($challenge))
		{
			$r .= \implode(',', $challenge);
		}

		return $r;
	}
}
