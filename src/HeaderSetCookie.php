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
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Import functions
 */
use function rawurlencode;
use function sprintf;
use function strpbrk;
use function time;

/**
 * @link https://tools.ietf.org/html/rfc6265#section-4.1
 * @link https://github.com/php/php-src/blob/master/ext/standard/head.c
 */
class HeaderSetCookie extends AbstractHeader
{

    /**
     * @var string
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite#lax
     */
    public const SAME_SITE_LAX = 'Lax';

    /**
     * @var string
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite#strict
     */
    public const SAME_SITE_STRICT = 'Strict';

    /**
     * @var string
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite#none
     */
    public const SAME_SITE_NONE = 'None';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var DateTimeInterface|null
     */
    protected $expires;

    /**
     * @var array{path?: ?string, domain?: ?string, secure?: ?bool, httpOnly?: ?bool, sameSite?: ?string}
     */
    protected $options;

    /**
     * @var array{path?: ?string, domain?: ?string, secure?: ?bool, httpOnly?: ?bool, sameSite?: ?string}
     */
    protected static $defaultOptions = [
        'path' => '/',
        'domain' => null,
        'secure' => null,
        'httpOnly' => true,
        'sameSite' => self::SAME_SITE_LAX,
    ];

    /**
     * Constructor of the class
     *
     * @param string $name
     * @param string $value
     * @param DateTimeInterface|null $expires
     * @param array{path?: ?string, domain?: ?string, secure?: ?bool, httpOnly?: ?bool, sameSite?: ?string} $options
     */
    public function __construct(string $name, string $value, ?DateTimeInterface $expires = null, array $options = [])
    {
        $options += static::$defaultOptions;

        $this->validateCookieName($name);

        if (isset($options['path'])) {
            $this->validateCookieStringOption('path', $options['path']);
        }

        if (isset($options['domain'])) {
            $this->validateCookieStringOption('domain', $options['domain']);
        }

        if (isset($options['sameSite'])) {
            $this->validateCookieStringOption('sameSite', $options['sameSite']);
        }

        if ($value === '') {
            $value = 'deleted';
            $expires = new DateTimeImmutable('1 year ago');
        }

        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
        $this->options = $options;
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
        $name = rawurlencode($this->name);
        $value = rawurlencode($this->value);

        $result = sprintf('%s=%s', $name, $value);

        if (isset($this->expires)) {
            $result .= '; Expires=' . $this->formatDateTime($this->expires);

            $maxAge = $this->expires->getTimestamp() - time();

            // cannot be less than zero...
            if ($maxAge < 0) {
                $maxAge = 0;
            }

            $result .= '; Max-Age=' . $maxAge;
        }

        if (isset($this->options['path'])) {
            $result .= '; Path=' . $this->options['path'];
        }

        if (isset($this->options['domain'])) {
            $result .= '; Domain=' . $this->options['domain'];
        }

        if (isset($this->options['secure']) && $this->options['secure']) {
            $result .= '; Secure';
        }

        if (isset($this->options['httpOnly']) && $this->options['httpOnly']) {
            $result .= '; HttpOnly';
        }

        if (isset($this->options['sameSite'])) {
            $result .= '; SameSite=' . $this->options['sameSite'];
        }

        return $result;
    }

    /**
     * Validates the cookie name
     *
     * @param string $name
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If a cookie's name isn't valid.
     */
    private function validateCookieName(string $name) : void
    {
        if ('' === $name) {
            throw new InvalidArgumentException('Cookie name cannot be empty');
        }

        if (strpbrk($name, "=,; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(sprintf(
                'The cookie "%s" contains prohibited characters',
                $name
            ));
        }
    }

    /**
     * Validates the cookie's string option
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If a cookie's string option isn't valid.
     */
    private function validateCookieStringOption(string $key, $value) : void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException(sprintf(
                'The cookie option "%s" must be a string',
                $key
            ));
        }

        if (strpbrk($value, ",; \t\r\n\013\014") !== false) {
            throw new InvalidArgumentException(sprintf(
                'The cookie option "%s" contains prohibited characters',
                $key
            ));
        }
    }
}
