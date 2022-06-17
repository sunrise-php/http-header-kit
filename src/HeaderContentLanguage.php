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
 * @link https://tools.ietf.org/html/rfc2616#section-14.12
 */
class HeaderContentLanguage extends AbstractHeader
{

    /**
     * @var list<string>
     */
    protected $languages;

    /**
     * Constructor of the class
     *
     * @param string ...$languages
     */
    public function __construct(string ...$languages)
    {
        /** @var list<string> $languages */

        $this->validateToken(...$languages);

        $this->languages = $languages;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Language';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        return implode(', ', $this->languages);
    }

    /**
     * {@inheritdoc}
     *
     * @link https://tools.ietf.org/html/rfc2616#section-3.10
     */
    protected function getTokenValidationRegularExpression() : string
    {
        return '/^[a-zA-Z]{1,8}(?:\-[a-zA-Z]{1,8})?$/';
    }
}
