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
 * @link https://www.w3.org/TR/CSP3/#cspro-header
 */
class HeaderContentSecurityPolicyReportOnly extends HeaderContentSecurityPolicy
{

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Security-Policy-Report-Only';
    }
}
