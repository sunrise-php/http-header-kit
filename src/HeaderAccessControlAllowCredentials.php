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
 * HeaderAccessControlAllowCredentials
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials
 */
class HeaderAccessControlAllowCredentials extends AbstractHeader implements HeaderInterface
{

	/**
	 * {@inheritDoc}
	 */
	public function getFieldName() : string
	{
		return 'Access-Control-Allow-Credentials';
	}

	/**
	 * {@inheritDoc}
	 */
	public function getFieldValue() : string
	{
		return 'true';
	}
}
