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
 * HeaderAccessControlExposeHeaders
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers
 */
class HeaderAccessControlExposeHeaders extends AbstractHeader implements HeaderInterface
{

    /**
     * The header value
     *
     * @var array
     */
    protected $value = [];

    /**
     * Constructor of the class
     *
     * @param string ...$value
     */
    public function __construct(string ...$value)
    {
        $this->setValue(...$value);
    }

    /**
     * Sets the header value
     *
     * @param string ...$value
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setValue(string ...$value) : self
    {
        foreach ($value as $oneOf) {
            if (! \preg_match(HeaderInterface::RFC7230_TOKEN, $oneOf)) {
                throw new \InvalidArgumentException(
                    \sprintf('The value "%s" for the header "%s" is not valid', $oneOf, $this->getFieldName())
                );
            }

            $this->value[$oneOf] = true;
        }

        return $this;
    }

    /**
     * Gets the header value
     *
     * @return array
     */
    public function getValue() : array
    {
        return \array_keys($this->value);
    }

    /**
     * Resets the header value
     *
     * @return self
     */
    public function resetValue() : self
    {
        $this->value = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldName() : string
    {
        return 'Access-Control-Expose-Headers';
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue() : string
    {
        return \implode(', ', $this->getValue());
    }
}
