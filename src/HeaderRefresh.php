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
 * @link https://en.wikipedia.org/wiki/Meta_refresh
 */
class HeaderRefresh extends AbstractHeader
{

    /**
     * @var int
     */
    protected $delay;

    /**
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
        $this->validateDelay($delay);

        $this->delay = $delay;
        $this->uri = $uri;
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
        return sprintf('%d; url=%s', $this->delay, $this->uri->__toString());
    }

    /**
     * Validates the redirection delay
     *
     * @param int $delay
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If the delay isn't valid.
     */
    private function validateDelay(int $delay) : void
    {
        if (! ($delay >= 0)) {
            throw new InvalidArgumentException(sprintf(
                'The delay "%2$d" for the header "%1$s" is not valid',
                $this->getFieldName(),
                $delay
            ));
        }
    }
}
