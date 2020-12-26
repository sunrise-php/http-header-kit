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
     * @var null|\DateTimeInterface
     */
    protected $expires;

    /**
     * The cookie attribute "Domain"
     *
     * @var null|string
     */
    protected $domain;

    /**
     * The cookie attribute "Path"
     *
     * @var null|string
     */
    protected $path;

    /**
     * The cookie attribute "Secure"
     *
     * @var null|bool
     */
    protected $secure;

    /**
     * The cookie attribute "HttpOnly"
     *
     * @var null|bool
     */
    protected $httponly;

    /**
     * The cookie attribute "SameSite"
     *
     * @var null|string
     */
    protected $samesite;

    /**
     * Constructor of the class
     *
     * @param string $name
     * @param string $value
     * @param null|\DateTimeInterface $expires
     * @param array $options
     */
    public function __construct(string $name, string $value, \DateTimeInterface $expires = null, array $options = [])
    {
        $this->setName($name);
        $this->setValue($value);
        $this->setExpires($expires);

        if (\array_key_exists('domain', $options)) {
            $this->setDomain($options['domain']);
        }

        if (\array_key_exists('path', $options)) {
            $this->setPath($options['path']);
        }

        if (\array_key_exists('secure', $options)) {
            $this->setSecure($options['secure']);
        }

        if (\array_key_exists('httponly', $options)) {
            $this->setHttpOnly($options['httponly']);
        }

        if (\array_key_exists('samesite', $options)) {
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
     * @throws \InvalidArgumentException
     */
    public function setName(string $name) : self
    {
        if (! (\strlen($name) > 0)) {
            throw new \InvalidArgumentException(
                'Cookie names must not be empty'
            );
        }

        if (! (\strpbrk($name, "=,; \t\r\n\013\014") === false)) {
            throw new \InvalidArgumentException(
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
     * @param null|\DateTimeInterface $expires
     *
     * @return self
     */
    public function setExpires(?\DateTimeInterface $expires) : self
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Sets the cookie attribute "Domain"
     *
     * @param null|string $domain
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setDomain(?string $domain) : self
    {
        if (! (\is_null($domain) || \strpbrk($domain, ",; \t\r\n\013\014") === false)) {
            throw new \InvalidArgumentException(
                'Cookie domains cannot contain any of the following ",; \\t\\r\\n\\013\\014"'
            );
        }

        $this->domain = $domain;

        return $this;
    }

    /**
     * Sets the cookie attribute "Path"
     *
     * @param null|string $path
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setPath(?string $path) : self
    {
        if (! (\is_null($path) || \strpbrk($path, ",; \t\r\n\013\014") === false)) {
            throw new \InvalidArgumentException(
                'Cookie paths cannot contain any of the following ",; \\t\\r\\n\\013\\014"'
            );
        }

        $this->path = $path;

        return $this;
    }

    /**
     * Sets the cookie attribute "Secure"
     *
     * @param null|bool $secure
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
     * @param null|bool $httponly
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
     * @param null|string $samesite
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setSameSite(?string $samesite) : self
    {
        if (! (\is_null($samesite) || \strpbrk($samesite, ",; \t\r\n\013\014") === false)) {
            throw new \InvalidArgumentException(
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
     * @return null|\DateTimeInterface
     */
    public function getExpires() : ?\DateTimeInterface
    {
        return $this->expires;
    }

    /**
     * Gets the cookie attribute "Domain"
     *
     * @return null|string
     */
    public function getDomain() : ?string
    {
        return $this->domain;
    }

    /**
     * Gets the cookie attribute "Path"
     *
     * @return null|string
     */
    public function getPath() : ?string
    {
        return $this->path;
    }

    /**
     * Gets the cookie attribute "Secure"
     *
     * @return null|bool
     */
    public function getSecure() : ?bool
    {
        return $this->secure;
    }

    /**
     * Gets the cookie attribute "HttpOnly"
     *
     * @return null|bool
     */
    public function getHttpOnly() : ?bool
    {
        return $this->httponly;
    }

    /**
     * Gets the cookie attribute "SameSite"
     *
     * @return null|string
     */
    public function getSameSite() : ?string
    {
        return $this->samesite;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldName() : string
    {
        return 'Set-Cookie';
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue() : string
    {
        $name = \rawurlencode($this->getName());
        $value = \rawurlencode($this->getValue());
        $result = \sprintf('%s=%s', $name, $value);

        if ($this->getExpires() instanceof \DateTimeInterface) {
            $this->getExpires()->setTimezone(new \DateTimeZone('GMT'));

            $result .= '; Expires=' . $this->getExpires()->format(\DateTime::RFC822);
            $result .= '; Max-Age=' . ($this->getExpires()->getTimestamp() - \time());
        }

        if ($this->getDomain()) {
            $result .= '; Domain=' . $this->getDomain();
        }

        if ($this->getPath()) {
            $result .= '; Path=' . $this->getPath();
        }

        if ($this->getSecure()) {
            $result .= '; Secure';
        }

        if ($this->getHttpOnly()) {
            $result .= '; HttpOnly';
        }

        if ($this->getSameSite()) {
            $result .= '; SameSite=' . $this->getSameSite();
        }

        return $result;
    }
}
