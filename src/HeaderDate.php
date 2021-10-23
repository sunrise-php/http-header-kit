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
use DateTimeInterface;
use DateTimeZone;

/**
 * HeaderDate
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.18
 * @link https://tools.ietf.org/html/rfc822#section-5
 */
class HeaderDate extends AbstractHeader implements HeaderInterface
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
        return 'Date';
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldValue() : string
    {
        $this->getTimestamp()->setTimezone(new DateTimeZone('GMT'));

        return $this->getTimestamp()->format(DateTime::RFC822);
    }
}
