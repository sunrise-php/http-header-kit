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
 * @link https://tools.ietf.org/html/rfc2616#section-14.10
 */
class HeaderConnection extends AbstractHeader
{

    /**
     * @var string
     */
    public const CONNECTION_CLOSE = 'close';

    /**
     * @var string
     */
    public const CONNECTION_KEEP_ALIVE = 'keep-alive';

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
        $this->validateToken($value);

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Connection';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return $this->value;
    }
}
