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
 * @link https://www.w3.org/TR/CSP3/#csp-header
 */
class HeaderContentSecurityPolicy extends AbstractHeader
{

    /**
     * @var array<string, string>
     */
    protected $parameters;

    /**
     * Constructor of the class
     *
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        /** @var array<string, string> */
        $parameters = $this->validateParameters($parameters);

        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Security-Policy';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $directives = [];
        foreach ($this->parameters as $directive => $value) {
            // the directive can be without value...
            // e.g. sandbox, upgrade-insecure-requests, etc.
            if ($value === '') {
                $directives[] = $directive;
                continue;
            }

            $directives[] = sprintf('%s %s', $directive, $value);
        }

        return implode('; ', $directives);
    }

    /**
     * {@inheritdoc}
     *
     * @link https://www.w3.org/TR/CSP3/#framework-directives
     */
    protected function getParameterNameValidationRegularExpression() : string
    {
        return '/^[0-9A-Za-z\-]+$/';
    }

    /**
     * {@inheritdoc}
     *
     * @link https://www.w3.org/TR/CSP3/#framework-directives
     */
    protected function getParameterValueValidationRegularExpression() : string
    {
        return '/^[\x09\x20-\x2B\x2D-\x3A\x3C-\x7E]*$/';
    }
}
