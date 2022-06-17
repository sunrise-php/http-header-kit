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
 * @link https://tools.ietf.org/html/rfc7235#section-4.1
 */
class HeaderWWWAuthenticate extends AbstractHeader
{

    /**
     * HTTP Authentication Schemes
     *
     * @link https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
     */
    public const HTTP_AUTHENTICATE_SCHEME_BASIC         = 'Basic';
    public const HTTP_AUTHENTICATE_SCHEME_BEARER        = 'Bearer';
    public const HTTP_AUTHENTICATE_SCHEME_DIGEST        = 'Digest';
    public const HTTP_AUTHENTICATE_SCHEME_HOBA          = 'HOBA';
    public const HTTP_AUTHENTICATE_SCHEME_MUTUAL        = 'Mutual';
    public const HTTP_AUTHENTICATE_SCHEME_NEGOTIATE     = 'Negotiate';
    public const HTTP_AUTHENTICATE_SCHEME_OAUTH         = 'OAuth';
    public const HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_1   = 'SCRAM-SHA-1';
    public const HTTP_AUTHENTICATE_SCHEME_SCRAM_SHA_256 = 'SCRAM-SHA-256';
    public const HTTP_AUTHENTICATE_SCHEME_VAPID         = 'vapid';

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var array<string, string>
     */
    protected $parameters;

    /**
     * Constructor of the class
     *
     * @param string $scheme
     * @param array<array-key, mixed> $parameters
     */
    public function __construct(string $scheme, array $parameters = [])
    {
        $this->validateToken($scheme);

        /** @var array<string, string> */
        $parameters = $this->validateParameters($parameters);

        $this->scheme = $scheme;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'WWW-Authenticate';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $v = $this->scheme;

        $challenge = [];
        foreach ($this->parameters as $name => $value) {
            $challenge[] = sprintf(' %s="%s"', $name, $value);
        }

        if (!empty($challenge)) {
            $v .= implode(',', $challenge);
        }

        return $v;
    }
}
