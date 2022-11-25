## HTTP header kit for PHP 7.4+ compatible with PSR-7, Symfony and Laravel

[![Build Status](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/?branch=master)
[![Total Downloads](https://poser.pugx.org/sunrise/http-header-kit/downloads)](https://packagist.org/packages/sunrise/http-header-kit)
[![Latest Stable Version](https://poser.pugx.org/sunrise/http-header-kit/v/stable)](https://packagist.org/packages/sunrise/http-header-kit)
[![License](https://poser.pugx.org/sunrise/http-header-kit/license)](https://packagist.org/packages/sunrise/http-header-kit)

---

## Installation

```bash
composer require sunrise/http-header-kit
```

## How to use?

#### PSR-7

```php
$message->withHeader(...$header);
```

#### Symfony

```php
$response->headers->set(...$header);
```

#### Laravel

```php
$response->header(...$header);
```

### HTTP Headers

> ⚠️ Note that in the examples below will use PSR-7.

#### Custom header

> Use this header if you can't find a suitable one below.

```php
use Sunrise\Http\Header\HeaderCustom;
use Sunrise\Http\Message\ResponseFactory;

$header = new HeaderCustom('X-Fiend-Name', 'field-value');

(new ResponseFactory) ->createResponse()
    ->withHeader(...$header);
```

#### Access-Control-Allow-Credentials

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials

```php
use Sunrise\Http\Header\HeaderAccessControlAllowCredentials;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowCredentials();
$message = $message->withHeader(...$header);
```

#### Access-Control-Allow-Headers

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Headers

```php
use Sunrise\Http\Header\HeaderAccessControlAllowHeaders;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowHeaders('X-Custom-Header', 'Upgrade-Insecure-Requests');
$message = $message->withHeader(...$header);
```

#### Access-Control-Allow-Methods

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods

```php
use Sunrise\Http\Header\HeaderAccessControlAllowMethods;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowMethods('OPTIONS', 'HEAD', 'GET');
$message = $message->withHeader(...$header);
```

#### Access-Control-Allow-Origin

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin

```php
use Sunrise\Http\Header\HeaderAccessControlAllowOrigin;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Uri\UriFactory;

$message = (new ResponseFactory)->createResponse();

// A response that tells the browser to allow code from any origin to access
// a resource will include the following:
$header = new HeaderAccessControlAllowOrigin(null);
$message = $message->withHeader(...$header);

// A response that tells the browser to allow requesting code from the origin
// https://developer.mozilla.org to access a resource will include the following:
$uri = (new UriFactory)->createUri('https://developer.mozilla.org');
$header = new HeaderAccessControlAllowOrigin($uri);
$message = $message->withHeader(...$header);
```

#### Access-Control-Expose-Headers

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers

```php
use Sunrise\Http\Header\HeaderAccessControlExposeHeaders;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlExposeHeaders('Content-Length', 'X-Kuma-Revision');
$message = $message->withHeader(...$header);
```

#### Access-Control-Max-Age

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Max-Age

```php
use Sunrise\Http\Header\HeaderAccessControlMaxAge;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlMaxAge(600);
$message = $message->withHeader(...$header);
```

#### Age

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Age

```php
use Sunrise\Http\Header\HeaderAge;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAge(24);
$message = $message->withHeader(...$header);
```

#### Allow

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Allow

```php
use Sunrise\Http\Header\HeaderAllow;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAllow('OPTIONS', 'HEAD', 'GET');
$message = $message->withHeader(...$header);
```

#### Cache-Control

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control

```php
use Sunrise\Http\Header\HeaderCacheControl;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Preventing caching
$header = new HeaderCacheControl(['no-cache' => '', 'no-store' => '', 'must-revalidate' => '']);
$message = $message->withHeader(...$header);

// Caching static assets
$header = new HeaderCacheControl(['public' => '', 'max-age' => '31536000']);
$message = $message->withHeader(...$header);
```

#### Clear-Site-Data

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Clear-Site-Data

```php
use Sunrise\Http\Header\HeaderClearSiteData;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Single directive
$header = new HeaderClearSiteData(['cache']);
$message = $message->withHeader(...$header);

// Multiple directives (comma separated)
$header = new HeaderClearSiteData(['cache', 'cookies']);
$message = $message->withHeader(...$header);

// Wild card
$header = new HeaderClearSiteData(['*']);
$message = $message->withHeader(...$header);
```

#### Connection

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Connection

```php
use Sunrise\Http\Header\HeaderConnection;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// close
$header = new HeaderConnection(HeaderConnection::CONNECTION_CLOSE);
$message = $message->withHeader(...$header);

// keep-alive
$header = new HeaderConnection(HeaderConnection::CONNECTION_KEEP_ALIVE);
$message = $message->withHeader(...$header);
```

#### Content-Disposition

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Disposition

```php
use Sunrise\Http\Header\HeaderContentDisposition;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// As a response header for the main body
$header = new HeaderContentDisposition('attachment', ['filename' => 'filename.jpg']);
$message = $message->withHeader(...$header);

// As a header for a multipart body
$header = new HeaderContentDisposition('form-data', ['name' => 'fieldName', 'filename' => 'filename.jpg']);
$message = $message->withHeader(...$header);
```

#### Content-Encoding

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Encoding

```php
use Sunrise\Http\Header\HeaderContentEncoding;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentEncoding('gzip');
$message = $message->withHeader(...$header);
```

#### Content-Language

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Language

```php
use Sunrise\Http\Header\HeaderContentLanguage;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentLanguage('de-DE', 'en-CA');
$message = $message->withHeader(...$header);
```

#### Content-Length

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Length

```php
use Sunrise\Http\Header\HeaderContentLength;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentLength(4096);
$message = $message->withHeader(...$header);
```

#### Content-Location

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Location

```php
use Sunrise\Http\Header\HeaderContentLocation;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Uri\UriFactory;

$message = (new ResponseFactory)->createResponse();

$uri = (new UriFactory)->createUri('https://example.com/documents/foo');
$header = new HeaderContentLocation($uri);
$message = $message->withHeader(...$header);
```

#### Content-MD5

> Useful link: https://tools.ietf.org/html/rfc1864

```php
use Sunrise\Http\Header\HeaderContentMD5;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentMD5('MzAyMWU2OGRmOWE3MjAwMTM1NzI1YzYzMzEzNjlhMjI=');
$message = $message->withHeader(...$header);
```

#### Content-Range

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Range

```php
use Sunrise\Http\Header\HeaderContentRange;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentRange(
    200, // An integer in the given unit indicating the beginning of the request range.
    1000, // An integer in the given unit indicating the end of the requested range.
    67589 // The total size of the document.
);
$message = $message->withHeader(...$header);
```

#### Content-Security-Policy

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy

```php
use Sunrise\Http\Header\HeaderContentSecurityPolicy;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Pre-existing site that uses too much inline code to fix but wants
// to ensure resources are loaded only over https and disable plugins:
$header = new HeaderContentSecurityPolicy(['default-src' => "https: 'unsafe-eval' 'unsafe-inline'", 'object-src' => "'none'"]);
$message = $message->withAddedHeader(...$header);

// Don't implement the above policy yet; instead just report
// violations that would have occurred:
$header = new HeaderContentSecurityPolicy(['default-src' => 'https:', 'report-uri' => '/csp-violation-report-endpoint/']);
$message = $message->withAddedHeader(...$header);
```

#### Content-Security-Policy-Report-Only

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy-Report-Only

```php
use Sunrise\Http\Header\HeaderContentSecurityPolicyReportOnly;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// This header reports violations that would have occurred.
// You can use this to iteratively work on your content security policy.
// You observe how your site behaves, watching for violation reports,
// then choose the desired policy enforced by the Content-Security-Policy header.
$header = new HeaderContentSecurityPolicy(['default-src' => 'https:', 'report-uri' => '/csp-violation-report-endpoint/']);
$message = $message->withAddedHeader(...$header);

// If you still want to receive reporting, but also want
// to enforce a policy, use the Content-Security-Policy header with the report-uri directive.
$header = new HeaderContentSecurityPolicy(['default-src' => 'https:', 'report-uri' => '/csp-violation-report-endpoint/']);
$message = $message->withAddedHeader(...$header);
```

#### Content-Type

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type

```php
use Sunrise\Http\Header\HeaderContentType;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentType('application/json', ['charset' => 'utf-8']);
$message = $message->withHeader(...$header);
```

#### Cookie

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie

```php
use Sunrise\Http\Header\HeaderCookie;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderCookie(['name' => 'value', 'name2' => 'value2', 'name3' => 'value3']);
$message = $message->withHeader(...$header);
```

#### Date

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date

```php
use Sunrise\Http\Header\HeaderDate;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderDate(new \DateTime('now'));
$message = $message->withHeader(...$header);
```

#### Etag

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag

```php
use Sunrise\Http\Header\HeaderEtag;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderEtag('33a64df551425fcc55e4d42a148795d9f25f89d4');
$message = $message->withHeader(...$header);
```

#### Expires

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expires

```php
use Sunrise\Http\Header\HeaderExpires;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderExpires(new \DateTime('1 day ago'));
$message = $message->withHeader(...$header);
```

#### Keep-Alive

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Keep-Alive

```php
use Sunrise\Http\Header\HeaderKeepAlive;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderKeepAlive(['timeout' => '5', 'max' => '1000']);
$message = $message->withHeader(...$header);
```

#### Last-Modified

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified

```php
use Sunrise\Http\Header\HeaderLastModified;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderLastModified(new \DateTime('1 year ago'));
$message = $message->withHeader(...$header);
```

#### Link

> Useful link: https://www.w3.org/wiki/LinkHeader

```php
use Sunrise\Http\Header\HeaderLink;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Uri\UriFactory;

$message = (new ResponseFactory)->createResponse();

$uri = (new UriFactory)->createUri('meta.rdf');
$header = new HeaderLink($uri, ['rel' => 'meta']);
$message = $message->withHeader(...$header);
```

#### Location

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Location

```php
use Sunrise\Http\Header\HeaderLocation;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Uri\UriFactory;

$message = (new ResponseFactory)->createResponse();

$uri = (new UriFactory)->createUri('/');
$header = new HeaderLocation($uri);
$message = $message->withHeader(...$header);
```

#### Refresh

> Useful link: https://en.wikipedia.org/wiki/Meta_refresh

```php
use Sunrise\Http\Header\HeaderRefresh;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Uri\UriFactory;

$message = (new ResponseFactory)->createResponse();

$uri = (new UriFactory)->createUri('/login');
$header = new HeaderRefresh(3, $uri);
$message = $message->withHeader(...$header);
```

#### Retry-After

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Retry-After

```php
use Sunrise\Http\Header\HeaderRetryAfter;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderRetryAfter(new \DateTime('+30 second'));
$message = $message->withHeader(...$header);
```

#### Set-Cookie

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie

```php
use Sunrise\Http\Header\HeaderSetCookie;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Session cookie
// Session cookies will get removed when the client is shut down.
// They don't specify the Expires or Max-Age directives.
// Note that web browser have often enabled session restoring.
$header = new HeaderSetCookie('sessionid', '38afes7a8', null, ['path' => '/', 'httponly' => true]);
$message = $message->withAddedHeader(...$header);

// Permanent cookie
// Instead of expiring when the client is closed, permanent cookies expire
// at a specific date (Expires) or after a specific length of time (Max-Age).
$header = new HeaderSetCookie('id', 'a3fWa', new \DateTime('+1 day'), ['secure' => true, 'httponly' => true]);
$message = $message->withAddedHeader(...$header);

// Invalid domains
// A cookie belonging to a domain that does not include the origin server
// should be rejected by the user agent. The following cookie will be rejected
// if it was set by a server hosted on originalcompany.com.
$header = new HeaderSetCookie('qwerty', '219ffwef9w0f', new \DateTime('+1 day'), ['domain' => 'somecompany.co.uk', 'path' => '/']);
$message = $message->withAddedHeader(...$header);
```

#### Sunset

> Useful link: https://tools.ietf.org/id/draft-wilde-sunset-header-03.html

```php
use Sunrise\Http\Header\HeaderSunset;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderSunset(new \DateTime('2038-01-19 03:14:07'));
$message = $message->withHeader(...$header);
```

#### Trailer

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Trailer

```php
use Sunrise\Http\Header\HeaderTrailer;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderTrailer('Expires', 'X-Streaming-Error');
$message = $message->withHeader(...$header);
```

#### Transfer-Encoding

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Transfer-Encoding

```php
use Sunrise\Http\Header\HeaderTransferEncoding;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderTransferEncoding('gzip', 'chunked');
$message = $message->withHeader(...$header);
```

#### Vary

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Vary

```php
use Sunrise\Http\Header\HeaderVary;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderVary('User-Agent', 'Content-Language');
$message = $message->withHeader(...$header);
```

#### WWW-Authenticate

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/WWW-Authenticate

```php
use Sunrise\Http\Header\HeaderWWWAuthenticate;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderWWWAuthenticate(HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BASIC, ['realm' => 'Access to the staging site', 'charset' => 'UTF-8']);
$message = $message->withHeader(...$header);
```

#### Warning

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Warning

```php
use Sunrise\Http\Header\HeaderWarning;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderWarning(HeaderWarning::HTTP_WARNING_CODE_RESPONSE_IS_STALE, 'anderson/1.3.37', 'Response is stale', new \DateTime('now'));
$message = $message->withHeader(...$header);
```

### HTTP header collection

```php
// Create the header collection:
$headers = new \Sunrise\Http\Header\HeaderCollection([
    new \Sunrise\Http\Header\HeaderAllow('HEAD', 'GET'),
    new \Sunrise\Http\Header\HeaderContentLanguage('de-DE'),
    new \Sunrise\Http\Header\HeaderContentType('application/json', [
        'charset' => 'UTF-8',
    ]),
]);

// ...and convert the collection to an array:
$headers->all();
```

---

## Test run

```bash
composer test
```

## Useful links

* https://www.php-fig.org/psr/psr-7/
