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
 * HeaderCustom
 */
class HeaderCustom extends AbstractHeader implements HeaderInterface
{

    /**
     * The header name
     *
     * @var string
     */
    protected $fieldName;

    /**
     * The header value
     *
     * @var string
     */
    protected $fieldValue;

    /**
     * Constructor of the class
     *
     * @param string $fieldName
     * @param string $fieldValue
     *
     * @throws InvalidArgumentException
     *         If the name or value isn't valid.
     */
    public function __construct(string $fieldName, string $fieldValue)
    {
        if (!preg_match(HeaderInterface::RFC7230_TOKEN, $fieldName)) {
            throw new InvalidArgumentException(sprintf('Name of the header "%s" is not valid', $fieldName));
        }

        if (!preg_match(HeaderInterface::RFC7230_FIELD_VALUE, $fieldValue)) {
            throw new InvalidArgumentException(sprintf('Value of the header "%s" is not valid', $fieldName));
        }

        $this->fieldName = $fieldName;
        $this->fieldValue = $fieldValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return $this->fieldName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return $this->fieldValue;
    }
}
