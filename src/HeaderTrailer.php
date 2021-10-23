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

/**
 * Import functions
 */
use function preg_match;
use function sprintf;

/**
 * HeaderTrailer
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.40
 */
class HeaderTrailer extends AbstractHeader implements HeaderInterface
{

    /**
     * The header value
     *
     * @var string
     */
    protected $value;

    /**
     * Constructor of the class
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * Sets the given value as the header value
     *
     * @param string $value
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setValue(string $value) : self
    {
        if (!preg_match(HeaderInterface::RFC7230_TOKEN, $value)) {
            throw new InvalidArgumentException(sprintf(
                'The header field "%s: %s" is not valid',
                $this->getFieldName(),
                $value
            ));
        }

        $this->value = $value;

        return $this;
    }

    /**
     * Gets the header value
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Trailer';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return $this->getValue();
    }
}
