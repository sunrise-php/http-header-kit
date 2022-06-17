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
 * Import functions
 */
use function implode;
use function sprintf;

/**
 * @link https://tools.ietf.org/html/rfc2068#section-19.7.1.1
 */
class HeaderKeepAlive extends AbstractHeader
{

    /**
     * @var array<string, string>
     */
    protected $parameters;

    /**
     * Constructor of the class
     *
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        /** @var array<string, string> */
        $parameters = $this->validateParameters($parameters);

        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Keep-Alive';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $segments = [];
        foreach ($this->parameters as $name => $value) {
            // the construction <foo=> isn't valid...
            if ($value === '') {
                $segments[] = $name;
                continue;
            }

            $format = $this->isToken($value) ? '%s=%s' : '%s="%s"';

            $segments[] = sprintf($format, $name, $value);
        }

        return implode(', ', $segments);
    }
}
