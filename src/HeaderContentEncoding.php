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
 * @link https://tools.ietf.org/html/rfc2616#section-14.11
 */
class HeaderContentEncoding extends AbstractHeader
{

    /**
     * Directives
     *
     * @var string
     */
    public const GZIP = 'gzip';
    public const COMPRESS = 'compress';
    public const DEFLATE = 'deflate';
    public const BR = 'br';

    /**
     * @var list<string>
     */
    protected $directives;

    /**
     * Constructor of the class
     *
     * @param string ...$directives
     */
    public function __construct(string ...$directives)
    {
        /** @var list<string> $directives */

        $this->validateToken(...$directives);

        $this->directives = $directives;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Encoding';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return implode(', ', $this->directives);
    }
}
