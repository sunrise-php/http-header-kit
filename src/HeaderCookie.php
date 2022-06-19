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
use function http_build_query;

/**
 * Import constants
 */
use const PHP_QUERY_RFC3986;

/**
 * @link https://tools.ietf.org/html/rfc6265.html#section-5.4
 */
class HeaderCookie extends AbstractHeader
{

    /**
     * @var array
     */
    protected $value;

    /**
     * Constructor of the class
     *
     * @param array $value
     */
    public function __construct(array $value = [])
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Cookie';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return http_build_query($this->value, '', '; ', PHP_QUERY_RFC3986);
    }
}
