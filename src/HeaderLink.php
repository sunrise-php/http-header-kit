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
 * Import functions
 */
use function sprintf;

/**
 * @link https://tools.ietf.org/html/rfc5988
 */
class HeaderLink extends AbstractHeader
{

    /**
     * @var UriInterface
     */
    protected $uri;

    /**
     * @var array<string, string>
     */
    protected $parameters;

    /**
     * Constructor of the class
     *
     * @param UriInterface $uri
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(UriInterface $uri, array $parameters = [])
    {
        /** @var array<string, string> */
        $parameters = $this->validateParameters($parameters);

        $this->uri = $uri;
        $this->parameters = $parameters;

    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Link';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $v = sprintf('<%s>', $this->uri->__toString());
        foreach ($this->parameters as $name => $value) {
            $v .= sprintf('; %s="%s"', $name, $value);
        }

        return $v;
    }
}
