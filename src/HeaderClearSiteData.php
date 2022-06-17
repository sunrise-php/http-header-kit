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
use function sprintf;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Clear-Site-Data
 */
class HeaderClearSiteData extends AbstractHeader
{

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

        $this->validateQuotedString(...$directives);

        $this->directives = $directives;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Clear-Site-Data';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $segments = [];
        foreach ($this->directives as $directive) {
            $segments[] = sprintf('"%s"', $directive);
        }

        return implode(', ', $segments);
    }
}
