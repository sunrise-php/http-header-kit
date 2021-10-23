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
use function preg_match;
use function sprintf;

/**
 * HeaderContentType
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.17
 */
class HeaderContentType extends AbstractHeader implements HeaderInterface
{

    /**
     * Regular Expression for a media-type validation
     *
     * @var string
     *
     * @link https://tools.ietf.org/html/rfc6838#section-4.2
     */
    public const VALID_MEDIA_TYPE = '/^[\dA-Za-z][\d\w\!#\$&\+\-\.\^]*(?:\/[\dA-Za-z][\d\w\!#\$&\+\-\.\^]*)?$/';

    /**
     * The content media-type
     *
     * @var string
     */
    protected $type;

    /**
     * The content media-type parameters
     *
     * @var array<string, string>
     */
    protected $parameters = [];

    /**
     * Constructor of the class
     *
     * @param string $type
     * @param array<string, string> $parameters
     */
    public function __construct(string $type, array $parameters = [])
    {
        $this->setType($type);
        $this->setParameters($parameters);
    }

    /**
     * Sets the content media-type
     *
     * @param string $type
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setType(string $type) : self
    {
        if (!preg_match(self::VALID_MEDIA_TYPE, $type)) {
            throw new InvalidArgumentException(sprintf(
                'The header field "%s: %s" is not valid',
                $this->getFieldName(),
                $type
            ));
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Sets the content media-type parameter
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
     * Sets the content media-type parameters
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
     * Gets the content media-type
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Gets the content media-type parameters
     *
     * @return array<string, string>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * Clears the content media-type parameters
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
        return 'Content-Type';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $r = $this->getType();
        foreach ($this->getParameters() as $name => $value) {
            $r .= sprintf('; %s="%s"', $name, $value);
        }

        return $r;
    }
}
