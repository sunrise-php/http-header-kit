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
use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

/**
 * Import functions
 */
use function sprintf;

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
     * @var UriInterface|null
     */
    protected $uri;

    /**
     * Constructor of the class
     *
     * @param UriInterface|null $uri
     */
    public function __construct(?UriInterface $uri)
    {
        $this->setUri($uri);
    }

    /**
     * Sets URI for the header field-value
     *
     * @param UriInterface|null $uri
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setUri(?UriInterface $uri) : self
    {
        if (isset($uri) && ('' === $uri->getScheme() || '' === $uri->getHost())) {
            throw new InvalidArgumentException(sprintf(
                'The header field "%s: %d" is not valid',
                $this->getFieldName(),
                (string) $uri
            ));
        }

        $this->uri = $uri;

        return $this;
    }

    /**
     * Gets URI for the header field-value
     *
     * @return UriInterface|null
     */
    public function getUri() : ?UriInterface
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Access-Control-Allow-Origin';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $uri = $this->getUri();
        if (null === $uri) {
            return '*';
        }

        $value = $uri->getScheme() . '://' . $uri->getHost();
        if (null !== $uri->getPort()) {
            $value .= ':' . $uri->getPort();
        }

        return $value;
    }
}
