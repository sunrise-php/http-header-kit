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
use function sprintf;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Max-Age
 */
class HeaderAccessControlMaxAge extends AbstractHeader
{

    /**
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
        $this->validateValue($value);

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Access-Control-Max-Age';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return sprintf('%d', $this->value);
    }

    /**
     * Validates the given value
     *
     * @param int $value
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If the value isn't valid.
     */
    private function validateValue(int $value) : void
    {
        if (! ($value === -1 || $value >= 1)) {
            throw new InvalidArgumentException(sprintf(
                'The value "%2$d" for the header "%1$s" is not valid',
                $this->getFieldName(),
                $value
            ));
        }
    }
}
