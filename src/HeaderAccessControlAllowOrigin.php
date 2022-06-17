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
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin
 */
class HeaderAccessControlAllowOrigin extends AbstractHeader
{

    /**
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
        if (isset($uri)) {
            $this->validateUri($uri);
        }

        $this->uri = $uri;
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
        if ($this->uri === null) {
            return '*';
        }

        $value = $this->uri->getScheme() . ':';
        $value .= '//' . $this->uri->getHost();

        $port = $this->uri->getPort();
        if (isset($port)) {
            $value .= ':' . $port;
        }

        return $value;
    }

    /**
     * Validates the given URI
     *
     * @param UriInterface $uri
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If the URI isn't valid.
     */
    private function validateUri(UriInterface $uri) : void
    {
        if ($uri->getScheme() === '' || $uri->getHost() === '') {
            throw new InvalidArgumentException(sprintf(
                'The URI "%2$s" for the header "%1$s" is not valid',
                $this->getFieldName(),
                $uri->__toString()
            ));
        }
    }
}
