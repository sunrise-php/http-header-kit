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
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

/**
 * Import functions
 */
use function array_key_exists;
use function rawurlencode;
use function sprintf;
use function strpbrk;
use function time;

/**
 * HeaderSetCookie
 *
 * @link https://tools.ietf.org/html/rfc6265#section-4.1
 * @link https://github.com/php/php-src/blob/master/ext/standard/head.c
 */
class HeaderSetCookie extends AbstractHeader implements HeaderInterface
{

    /**
     * The cookie name
     *
     * @var string
     */
    protected $name;

    /**
     * The cookie value
     *
     * @var string
     */
    protected $value;

    /**
     * The cookie attribute "Expires"
     *
     * @var DateTimeInterface|null
     */
    protected $expires;

    /**
     * The cookie attribute "Domain"
     *
     * @var string|null
     */
    protected $domain;

    /**
     * The cookie attribute "Path"
     *
     * @var string|null
     */
    protected $path;

    /**
     * The cookie attribute "Secure"
     *
     * @var bool|null
     */
    protected $secure;

    /**
     * The cookie attribute "HttpOnly"
     *
     * @var bool|null
     */
    protected $httponly;

    /**
     * The cookie attribute "SameSite"
     *
     * @var string|null
     */
    protected $samesite;

    /**
     * Constructor of the class
     *
     * @param string $name
     * @param string $value
     * @param DateTimeInterface|null $expires
     * @param T_Options $options
     *
     * @template T_Options as array{domain?: ?string, path?: ?string, secure?: ?bool, httponly?: ?bool, samesite?: ?string}
     */
    public function __construct(string $name, string $value, ?DateTimeInterface $expires = null, array $options = [])
    {
        $this->setName($name);
        $this->setValue($value);
        $this->setExpires($expires);

        if (array_key_exists('domain', $options)) {
            $this->setDomain($options['domain']);
        }

        if (array_key_exists('path', $options)) {
            $this->setPath($options['path']);
        }

        if (array_key_exists('secure', $options)) {
            $this->setSecure($options['secure']);
        }

        if (array_key_exists('httponly', $options)) {
            $this->setHttpOnly($options['httponly']);
        }

        if (array_key_exists('samesite', $options)) {
            $this->setSameSite($options['samesite']);
        }
    }

    /**
     * Sets the cookie name
     *
     * @param string $name
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setName(string $name) : self
    {
        if ('' === $name) {
            throw new InvalidArgumentException('Cookie names must not be empty');
        }

        if (strpbrk($name, "=,; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(
                'Cookie names cannot contain any of the following "=,; \\t\\r\\n\\013\\014"'
            );
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Sets the cookie value
     *
     * @param string $value
     *
     * @return self
     */
    public function setValue(string $value) : self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Sets the cookie attribute "Expires"
     *
     * @param DateTimeInterface|null $expires
     *
     * @return self
     */
    public function setExpires(?DateTimeInterface $expires) : self
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Sets the cookie attribute "Domain"
     *
     * @param string|null $domain
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setDomain(?string $domain) : self
    {
        if (isset($domain) && strpbrk($domain, ",; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(
                'Cookie domains cannot contain any of the following ",; \\t\\r\\n\\013\\014"'
            );
        }

        $this->domain = $domain;

        return $this;
    }

    /**
     * Sets the cookie attribute "Path"
     *
     * @param string|null $path
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setPath(?string $path) : self
    {
        if (isset($path) && strpbrk($path, ",; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(
                'Cookie paths cannot contain any of the following ",; \\t\\r\\n\\013\\014"'
            );
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Sets the cookie attribute "Secure"
     *
     * @param bool|null $secure
     *
     * @return self
     */
    public function setSecure(?bool $secure) : self
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * Sets the cookie attribute "HttpOnly"
     *
     * @param bool|null $httponly
     *
     * @return self
     */
    public function setHttpOnly(?bool $httponly) : self
    {
        $this->httponly = $httponly;

        return $this;
    }

    /**
     * Sets the cookie attribute "SameSite"
     *
     * @param string|null $samesite
     *
     * @return self
     *
     * @throws InvalidArgumentException
     */
    public function setSameSite(?string $samesite) : self
    {
        if (isset($samesite) && strpbrk($samesite, ",; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(
                'Cookie samesites cannot contain any of the following ",; \\t\\r\\n\\013\\014"'
            );
        }

        $this->samesite = $samesite;

        return $this;
    }

    /**
     * Gets the cookie name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Gets the cookie value
     *
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    /**
     * Gets the cookie attribute "Expires"
     *
     * @return DateTimeInterface|null
     */
    public function getExpires() : ?DateTimeInterface
    {
        return $this->expires;
    }

    /**
     * Gets the cookie attribute "Domain"
     *
     * @return string|null
     */
    public function getDomain() : ?string
    {
        return $this->domain;
    }

    /**
     * Gets the cookie attribute "Path"
     *
     * @return string|null
     */
    public function getPath() : ?string
    {
        return $this->path;
    }

    /**
     * Gets the cookie attribute "Secure"
     *
     * @return bool|null
     */
    public function getSecure() : ?bool
    {
        return $this->secure;
    }

    /**
     * Gets the cookie attribute "HttpOnly"
     *
     * @return bool|null
     */
    public function getHttpOnly() : ?bool
    {
        return $this->httponly;
    }

    /**
     * Gets the cookie attribute "SameSite"
     *
     * @return string|null
     */
    public function getSameSite() : ?string
    {
        return $this->samesite;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Set-Cookie';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $name = rawurlencode($this->getName());
        $value = rawurlencode($this->getValue());
        $result = sprintf('%s=%s', $name, $value);

        $expires = $this->getExpires();
        if ($expires instanceof DateTimeInterface) {

            /** @psalm-suppress RedundantCondition */
            if ($expires instanceof DateTime ||
                $expires instanceof DateTimeImmutable) {
                $expires->setTimezone(new DateTimeZone('GMT'));
            }

            $result .= '; Expires=' . $expires->format(DateTime::RFC822);
            $result .= '; Max-Age=' . ($expires->getTimestamp() - time());
        }

        $domain = $this->getDomain();
        if (isset($domain)) {
            $result .= '; Domain=' . $domain;
        }

        $path = $this->getPath();
        if (isset($path)) {
            $result .= '; Path=' . $path;
        }

        $secure = $this->getSecure();
        if (true === $secure) {
            $result .= '; Secure';
        }

        $httpOnly = $this->getHttpOnly();
        if (true === $httpOnly) {
            $result .= '; HttpOnly';
        }

        $sameSite = $this->getSameSite();
        if (isset($sameSite)) {
            $result .= '; SameSite=' . $sameSite;
        }

        return $result;
    }
}
