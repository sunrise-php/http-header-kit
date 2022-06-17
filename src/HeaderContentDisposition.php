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
 * @link https://tools.ietf.org/html/rfc2616#section-19.5.1
 */
class HeaderContentDisposition extends AbstractHeader
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
        return 'Content-Disposition';
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
}
