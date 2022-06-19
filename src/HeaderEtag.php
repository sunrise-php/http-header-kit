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
use function sprintf;

/**
 * @link https://tools.ietf.org/html/rfc2616#section-14.19
 */
class HeaderEtag extends AbstractHeader
{

    /**
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
        $this->validateQuotedString($value);

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'ETag';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return sprintf('"%s"', $this->value);
    }
}
