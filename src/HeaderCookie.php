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
 * HeaderCookie
 *
 * @link https://tools.ietf.org/html/rfc6265.html#section-5.4
 */
class HeaderCookie extends AbstractHeader implements HeaderInterface
{

    /**
     * The header value
     *
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
        $this->setValue($value);
    }

    /**
     * Sets the given value as the header value
     *
     * @param array $value
     *
     * @return self
     */
    public function setValue(array $value) : self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets the header value
     *
     * @return array
     */
    public function getValue() : array
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldName() : string
    {
        return 'Cookie';
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue() : string
    {
        return \http_build_query($this->getValue(), '', '; ', \PHP_QUERY_RFC3986);
    }
}
