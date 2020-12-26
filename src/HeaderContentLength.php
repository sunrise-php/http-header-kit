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
 * HeaderContentLength
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.13
 */
class HeaderContentLength extends AbstractHeader implements HeaderInterface
{

    /**
     * The header value
     *
     * @var int
     */
    protected $value;

    /**
     * Constructor of the class
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    /**
     * Sets the given value as the header value
     *
     * @param int $value
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setValue(int $value) : self
    {
        if (! ($value >= 0)) {
            throw new \InvalidArgumentException(
                \sprintf('The header field "%s: %d" is not valid', $this->getFieldName(), $value)
            );
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Gets the header value
     *
     * @return int
     */
    public function getValue() : int
    {
        return $this->value;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Length';
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue() : string
    {
        return \sprintf('%d', $this->getValue());
    }
}
