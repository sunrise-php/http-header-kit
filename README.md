## HTTP header kit for PHP 7.1+ (incl. PHP 8) based on PSR-7

[![Gitter](https://badges.gitter.im/sunrise-php/support.png)](https://gitter.im/sunrise-php/support)
[![Build Status](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sunrise-php/http-header-kit/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/sunrise/http-header-kit/v/stable)](https://packagist.org/packages/sunrise/http-header-kit)
[![Total Downloads](https://poser.pugx.org/sunrise/http-header-kit/downloads)](https://packagist.org/packages/sunrise/http-header-kit)
[![License](https://poser.pugx.org/sunrise/http-header-kit/license)](https://packagist.org/packages/sunrise/http-header-kit)

## Installation

```bash
composer require sunrise/http-header-kit
```

## How to use?

### HTTP Header Collection

> More useful information:
> 
> https://github.com/sunrise-php/http-header-collection

```bash
composer require sunrise/http-header-collection
```

```php
// Creates the header collection
$headers = new \Sunrise\Http\Header\HeaderCollection([
    new \Sunrise\Http\Header\HeaderAllow('OPTIONS', 'HEAD', 'GET'),
    new \Sunrise\Http\Header\HeaderContentLanguage('de-DE'),
    new \Sunrise\Http\Header\HeaderContentType('application/json'),
]);

// Sets headers to the message
$message = $headers->setToMessage($message);

// ... or adds headers to the message
$message = $headers->addToMessage($message);

// ...or converts headers to an array
$headers->toArray();
```

### HTTP Headers

#### Access-Control-Allow-Credentials

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials

```php
use Sunrise\Http\Header\HeaderAccessControlAllowCredentials;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowCredentials();
$message = $header->setToMessage($message);
```

#### Access-Control-Allow-Headers

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Headers

```php
use Sunrise\Http\Header\HeaderAccessControlAllowHeaders;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowHeaders('X-Custom-Header', 'Upgrade-Insecure-Requests');
$message = $header->setToMessage($message);
```

#### Access-Control-Allow-Methods

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods

```php
use Sunrise\Http\Header\HeaderAccessControlAllowMethods;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlAllowMethods('OPTIONS', 'HEAD', 'GET');
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);

// A response that tells the browser to allow requesting code from the origin
// https://developer.mozilla.org to access a resource will include the following:
$uri = (new UriFactory)->createUri('https://developer.mozilla.org');
$header = new HeaderAccessControlAllowOrigin($uri);
$message = $header->setToMessage($message);
```

#### Access-Control-Expose-Headers

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers

```php
use Sunrise\Http\Header\HeaderAccessControlExposeHeaders;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlExposeHeaders('Content-Length', 'X-Kuma-Revision');
$message = $header->setToMessage($message);
```

#### Access-Control-Max-Age

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Max-Age

```php
use Sunrise\Http\Header\HeaderAccessControlMaxAge;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAccessControlMaxAge(600);
$message = $header->setToMessage($message);
```

#### Age

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Age

```php
use Sunrise\Http\Header\HeaderAge;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAge(24);
$message = $header->setToMessage($message);
```

#### Allow

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Allow

```php
use Sunrise\Http\Header\HeaderAllow;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderAllow('OPTIONS', 'HEAD', 'GET');
$message = $header->setToMessage($message);
```

#### Cache-Control

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control

```php
use Sunrise\Http\Header\HeaderCacheControl;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Preventing caching
$header = new HeaderCacheControl(['no-cache' => '', 'no-store' => '', 'must-revalidate' => '']);
$message = $header->setToMessage($message);

// Caching static assets
$header = new HeaderCacheControl(['public' => '', 'max-age' => '31536000']);
$message = $header->setToMessage($message);
```

#### Clear-Site-Data

> Usage link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Clear-Site-Data

```php
use Sunrise\Http\Header\HeaderClearSiteData;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// Single directive
$header = new HeaderClearSiteData(['cache']);
$message = $header->setToMessage($message);

// Multiple directives (comma separated)
$header = new HeaderClearSiteData(['cache', 'cookies']);
$message = $header->setToMessage($message);

// Wild card
$header = new HeaderClearSiteData(['*']);
$message = $header->setToMessage($message);
```

#### Connection

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Connection

```php
use Sunrise\Http\Header\HeaderConnection;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// close
$header = new HeaderConnection(HeaderConnection::CONNECTION_CLOSE);
$message = $header->setToMessage($message);

// keep-alive
$header = new HeaderConnection(HeaderConnection::CONNECTION_KEEP_ALIVE);
$message = $header->setToMessage($message);
```

#### Content-Disposition

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Disposition

```php
use Sunrise\Http\Header\HeaderContentDisposition;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

// As a response header for the main body
$header = new HeaderContentDisposition('attachment', ['filename' => 'filename.jpg']);
$message = $header->setToMessage($message);

// As a header for a multipart body
$header = new HeaderContentDisposition('form-data', ['name' => 'fieldName', 'filename' => 'filename.jpg']);
$message = $header->setToMessage($message);
```

#### Content-Encoding

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Encoding

```php
use Sunrise\Http\Header\HeaderContentEncoding;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentEncoding('gzip');
$message = $header->setToMessage($message);
```

#### Content-Language

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Language

```php
use Sunrise\Http\Header\HeaderContentLanguage;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentLanguage('de-DE', 'en-CA');
$message = $header->setToMessage($message);
```

#### Content-Length

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Length

```php
use Sunrise\Http\Header\HeaderContentLength;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentLength(4096);
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);
```

#### Content-MD5

> Useful link: https://tools.ietf.org/html/rfc1864

```php
use Sunrise\Http\Header\HeaderContentMD5;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentMD5('MzAyMWU2OGRmOWE3MjAwMTM1NzI1YzYzMzEzNjlhMjI=');
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);
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
$message = $header->addToMessage($message);

// Don't implement the above policy yet; instead just report
// violations that would have occurred:
$header = new HeaderContentSecurityPolicy(['default-src' => 'https:', 'report-uri' => '/csp-violation-report-endpoint/']);
$message = $header->addToMessage($message);
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
$message = $header->addToMessage($message);

// If you still want to receive reporting, but also want
// to enforce a policy, use the Content-Security-Policy header with the report-uri directive.
$header = new HeaderContentSecurityPolicy(['default-src' => 'https:', 'report-uri' => '/csp-violation-report-endpoint/']);
$message = $header->addToMessage($message);
```

#### Content-Type

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Type

```php
use Sunrise\Http\Header\HeaderContentType;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderContentType('application/json', ['charset' => 'utf-8']);
$message = $header->setToMessage($message);
```

#### Cookie

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie

```php
use Sunrise\Http\Header\HeaderCookie;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderCookie(['name' => 'value', 'name2' => 'value2', 'name3' => 'value3']);
$message = $header->setToMessage($message);
```

#### Date

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Date

```php
use Sunrise\Http\Header\HeaderDate;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderDate(new \DateTime('now'));
$message = $header->setToMessage($message);
```

#### Etag

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag

```php
use Sunrise\Http\Header\HeaderEtag;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderEtag('33a64df551425fcc55e4d42a148795d9f25f89d4');
$message = $header->setToMessage($message);
```

#### Expires

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expires

```php
use Sunrise\Http\Header\HeaderExpires;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderExpires(new \DateTime('1 day ago'));
$message = $header->setToMessage($message);
```

#### Keep-Alive

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Keep-Alive

```php
use Sunrise\Http\Header\HeaderKeepAlive;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderKeepAlive(['timeout' => '5', 'max' => '1000']);
$message = $header->setToMessage($message);
```

#### Last-Modified

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified

```php
use Sunrise\Http\Header\HeaderLastModified;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderLastModified(new \DateTime('1 year ago'));
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);
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
$message = $header->setToMessage($message);
```

#### Retry-After

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Retry-After

```php
use Sunrise\Http\Header\HeaderRetryAfter;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderRetryAfter(new \DateTime('+30 second'));
$message = $header->setToMessage($message);
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
$message = $header->addToMessage($message);

// Permanent cookie
// Instead of expiring when the client is closed, permanent cookies expire
// at a specific date (Expires) or after a specific length of time (Max-Age).
$header = new HeaderSetCookie('id', 'a3fWa', new \DateTime('+1 day'), ['secure' => true, 'httponly' => true]);
$message = $header->addToMessage($message);

// Invalid domains
// A cookie belonging to a domain that does not include the origin server
// should be rejected by the user agent. The following cookie will be rejected
// if it was set by a server hosted on originalcompany.com.
$header = new HeaderSetCookie('qwerty', '219ffwef9w0f', new \DateTime('+1 day'), ['domain' => 'somecompany.co.uk', 'path' => '/']);
$message = $header->addToMessage($message);
```

#### Sunset

> Useful link: https://tools.ietf.org/id/draft-wilde-sunset-header-03.html

```php
use Sunrise\Http\Header\HeaderSunset;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderSunset(new \DateTime('2038-01-19 03:14:07'));
$message = $header->setToMessage($message);
```

#### Trailer

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Trailer

```php
use Sunrise\Http\Header\HeaderTrailer;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderTrailer('Expires', 'X-Streaming-Error');
$message = $header->setToMessage($message);
```

#### Transfer-Encoding

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Transfer-Encoding

```php
use Sunrise\Http\Header\HeaderTransferEncoding;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderTransferEncoding('gzip', 'chunked');
$message = $header->setToMessage($message);
```

#### Vary

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Vary

```php
use Sunrise\Http\Header\HeaderVary;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderVary('User-Agent', 'Content-Language');
$message = $header->setToMessage($message);
```

#### WWW-Authenticate

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/WWW-Authenticate

```php
use Sunrise\Http\Header\HeaderWWWAuthenticate;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderWWWAuthenticate(HeaderWWWAuthenticate::HTTP_AUTHENTICATE_SCHEME_BASIC, ['realm' => 'Access to the staging site', 'charset' => 'UTF-8']);
$message = $header->setToMessage($message);
```

#### Warning

> Useful link: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Warning

```php
use Sunrise\Http\Header\HeaderWarning;
use Sunrise\Http\Message\ResponseFactory;

$message = (new ResponseFactory)->createResponse();

$header = new HeaderWarning(HeaderWarning::HTTP_WARNING_CODE_RESPONSE_IS_STALE, 'anderson/1.3.37', 'Response is stale', new \DateTime('now'));
$message = $header->setToMessage($message);
```

## Test run

```bash
php vendor/bin/phpunit
```

## Useful links

* https://www.php-fig.org/psr/psr-7/
