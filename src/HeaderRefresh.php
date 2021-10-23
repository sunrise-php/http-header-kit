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
 * HeaderRefresh
 *
 * @link https://en.wikipedia.org/wiki/Meta_refresh
 */
class HeaderRefresh extends AbstractHeader implements HeaderInterface
{

    /**
     * Delay for the redirection
     *
     * @var int
     */
    protected $delay;

    /**
     * URI for the redirection
     *
     * @var UriInterface
     */
    protected $uri;

    /**
     * Constructor of the class
     *
     * @param int $delay
     * @param UriInterface $uri
     */
    public function __construct(int $delay, UriInterface $uri)
    {
        $this->setDelay($delay);
        $this->setUri($uri);
    }

    /**
     * Sets the redirection delay
     *
     * @param int $delay
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setDelay(int $delay) : self
    {
        if (! ($delay >= 0)) {
            throw new InvalidArgumentException(sprintf(
                'The given delay "%d" for the "Refresh" header is not valid',
                $delay
            ));
        }

        $this->delay = $delay;

        return $this;
    }

    /**
     * Sets the redirection URI
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
     * Gets the redirection delay
     *
     * @return int
     */
    public function getDelay() : int
    {
        return $this->delay;
    }

    /**
     * Gets the redirection URI
     *
     * @return UriInterface
     */
    public function getUri() : UriInterface
    {
        return $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Refresh';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return sprintf('%d; url=%s', $this->getDelay(), (string) $this->getUri());
    }
}
