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
 * @link https://tools.ietf.org/html/rfc2616#section-14.17
 */
class HeaderContentType extends AbstractHeader
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array<string, string>
     */
    protected $parameters;

    /**
     * Constructor of the class
     *
     * @param string $type
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(string $type, array $parameters = [])
    {
        $this->validateToken($type);

        /** @var array<string, string> */
        $parameters = $this->validateParameters($parameters);

        $this->type = $type;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Content-Type';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $v = $this->type;
        foreach ($this->parameters as $name => $value) {
            $v .= sprintf('; %s="%s"', $name, $value);
        }

        return $v;
    }

    /**
     * {@inheritdoc}
     *
     * @link https://tools.ietf.org/html/rfc6838#section-4.2
     */
    protected function getTokenValidationRegularExpression() : string
    {
        return '/^[\dA-Za-z][\d\w\!#\$&\+\-\.\^]*(?:\/[\dA-Za-z][\d\w\!#\$&\+\-\.\^]*)?$/';
    }
}
