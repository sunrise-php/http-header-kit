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
 * Custom header
 */
class HeaderCustom extends AbstractHeader
{

    /**
     * The header field-name
     *
     * @var string
     *
     * @readonly
     */
    private $fieldName;

    /**
     * The header field-value
     *
     * @var string
     *
     * @readonly
     */
    private $fieldValue;

    /**
     * Constructor of the class
     *
     * @param string $fieldName
     * @param string $fieldValue
     *
     * @throws InvalidArgumentException
     *         If the header field name of value isn't valid.
     */
    public function __construct($fieldName, $fieldValue)
    {
        $this->validateFieldName($fieldName);
        $this->validateFieldValue($fieldValue);

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
