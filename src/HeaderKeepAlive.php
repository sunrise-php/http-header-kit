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
 * Import classes
 */
use InvalidArgumentException;

/**
 * Import functions
 */
use function implode;
use function preg_match;
use function sprintf;

/**
 * HeaderKeepAlive
 *
 * @link https://tools.ietf.org/html/rfc2068#section-19.7.1.1
 */
class HeaderKeepAlive extends AbstractHeader implements HeaderInterface
{

    /**
     * The header parameters
     *
     * @var array<string, string>
     */
    protected $parameters = [];

    /**
     * Constructor of the class
     *
     * @param array<string, string> $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * Sets the header parameter
     *
     * @param string $name
     * @param string $value
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setParameter(string $name, string $value) : self
    {
        if (!preg_match(HeaderInterface::RFC7230_TOKEN, $name)) {
            throw new InvalidArgumentException(sprintf(
                'The parameter-name "%s" for the header "%s" is not valid',
                $name,
                $this->getFieldName()
            ));
        }

        if (!preg_match(HeaderInterface::RFC7230_QUOTED_STRING, $value)) {
            throw new InvalidArgumentException(sprintf(
                'The parameter-value "%s" for the header "%s" is not valid',
                $value,
                $this->getFieldName()
            ));
        }

        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Sets the header parameters
     *
     * @param array<string, string> $parameters
     *
     * @return self
     */
    public function setParameters(array $parameters) : self
    {
        foreach ($parameters as $name => $value) {
            $this->setParameter($name, $value);
        }

        return $this;
    }

    /**
     * Gets the header parameters
     *
     * @return array<string, string>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * Clears the header parameters
     *
     * @return self
     */
    public function clearParameters() : self
    {
        $this->parameters = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Keep-Alive';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $parameters = [];
        foreach ($this->getParameters() as $name => $value) {
            if ('' === $value) {
                $parameters[] = $name;
                continue;
            }

            // e.g.: timeout=5, max=1000
            if (preg_match(HeaderInterface::RFC7230_TOKEN, $value)) {
                $parameters[] = $name . '=' . $value;
                continue;
            }

            $parameters[] = $name . '="' . $value . '"';
        }

        return implode(', ', $parameters);
    }
}
