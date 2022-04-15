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
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Import functions
 */
use function sprintf;

/**
 * AbstractHeader
 *
 * @template-implements IteratorAggregate<int, string>
 */
abstract class AbstractHeader implements HeaderInterface, IteratorAggregate
{

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        return sprintf(
            '%s: %s',
            $this->getFieldName(),
            $this->getFieldValue()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : Traversable
    {
        return new ArrayIterator([
            $this->getFieldName(),
            $this->getFieldValue(),
        ]);
    }
}
