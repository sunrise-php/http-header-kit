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
use function implode;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers
 */
class HeaderAccessControlExposeHeaders extends AbstractHeader
{

    /**
     * @var list<string>
     */
    protected $headers;

    /**
     * Constructor of the class
     *
     * @param string ...$headers
     */
    public function __construct(string ...$headers)
    {
        /** @var list<string> $headers */

        $this->validateToken(...$headers);

        $this->headers = $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Access-Control-Expose-Headers';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return implode(', ', $this->headers);
    }
}
