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

/**
 * HeaderExpires
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.21
 * @link https://tools.ietf.org/html/rfc822#section-5
 */
class HeaderExpires extends AbstractHeader implements HeaderInterface
{

    /**
     * Timestamp for the header field-value
     *
     * @var DateTimeInterface
     */
    protected $timestamp;

    /**
     * Constructor of the class
     *
     * @param DateTimeInterface $timestamp
     */
    public function __construct(DateTimeInterface $timestamp)
    {
        $this->setTimestamp($timestamp);
    }

    /**
     * Sets timestamp for the header field-value
     *
     * @param DateTimeInterface $timestamp
     *
     * @return self
     */
    public function setTimestamp(DateTimeInterface $timestamp) : self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Gets timestamp for the header field-value
     *
     * @return DateTimeInterface
     */
    public function getTimestamp() : DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldName() : string
    {
        return 'Expires';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $timestamp = $this->getTimestamp();

        /** @psalm-suppress RedundantCondition */
        if ($timestamp instanceof DateTime ||
            $timestamp instanceof DateTimeImmutable) {
            $timestamp->setTimezone(new DateTimeZone('GMT'));
        }

        return $timestamp->format(DateTime::RFC822);
    }
}
