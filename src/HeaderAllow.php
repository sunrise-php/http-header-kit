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
use function strtoupper;

/**
 * @link https://tools.ietf.org/html/rfc2616#section-14.7
 */
class HeaderAllow extends AbstractHeader
{

    /**
     * @var list<string>
     */
    protected $methods = [];

    /**
     * Constructor of the class
     *
     * @param string ...$methods
     */
    public function __construct(string ...$methods)
    {
        /** @var list<string> $methods */

        $this->validateToken(...$methods);

        // normalize the list of methods...
        foreach ($methods as $method) {
            $this->methods[] = strtoupper($method);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Allow';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return implode(', ', $this->methods);
    }
}
