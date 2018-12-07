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
 * HeaderAccessControlAllowOrigin
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
 */
class HeaderAccessControlAllowOrigin extends AbstractHeader implements HeaderInterface
{

	/**
	 * URI for the header field-value
	 *
	 * @var null|UriInterface
	 */
	protected $uri;

	/**
	 * Constructor of the class
	 *
	 * @param null|UriInterface $uri
	 */
	public function __construct(?UriInterface $uri)
	{
		$this->setUri($uri);
	}

	/**
	 * Sets URI for the header field-value
	 *
	 * @param null|UriInterface $uri
	 *
	 * @return self
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setUri(?UriInterface $uri) : self
	{
		if (! (\is_null($uri) || (\strlen($uri->getScheme()) && \strlen($uri->getHost()))))
		{
			throw new \InvalidArgumentException(\sprintf('The header field "%s: %d" is not valid', $this->getFieldName(), (string) $uri));
		}

		$this->uri = $uri;

		return $this;
	}

	/**
	 * Gets URI for the header field-value
	 *
	 * @return null|UriInterface
	 */
	public function getUri() : ?UriInterface
	{
		return $this->uri;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldName() : string
	{
		return 'Access-Control-Allow-Origin';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		$uri = $this->getUri();

		if ($uri instanceof UriInterface)
		{
			$value = $uri->getScheme() . ':';

			$value .= '//' . $uri->getHost();

			if (! (null === $uri->getPort()))
			{
				$value .= ':' . $uri->getPort();
			}

			return $value;
		}

		return '*';
	}
}
