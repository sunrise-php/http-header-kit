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
 * HeaderWarning
 *
 * @link https://tools.ietf.org/html/rfc2616#section-14.46
 */
class HeaderWarning extends AbstractHeader implements HeaderInterface
{

    /**
     * HTTP Warning Codes
     *
     * @link https://www.iana.org/assignments/http-warn-codes/http-warn-codes.xhtml
     */
    public const HTTP_WARNING_CODE_RESPONSE_IS_STALE = 110;
    public const HTTP_WARNING_CODE_REVALIDATION_FAILED = 111;
    public const HTTP_WARNING_CODE_DISCONNECTED_OPERATION = 112;
    public const HTTP_WARNING_CODE_HEURISTIC_EXPIRATION = 113;
    public const HTTP_WARNING_CODE_MISCELLANEOUS_WARNING = 199;
    public const HTTP_WARNING_CODE_TRANSFORMATION_APPLIED = 214;
    public const HTTP_WARNING_CODE_MISCELLANEOUS_PERSISTENT_WARNING = 299;

    /**
     * The warning code
     *
     * @var int
     */
    protected $code;

    /**
     * The warning agent
     *
     * @var string
     */
    protected $agent;

    /**
     * The warning text
     *
     * @var string
     */
    protected $text;

    /**
     * The warning date
     *
     * @var null|\DateTimeInterface
     */
    protected $date;

    /**
     * Constructor of the class
     *
     * @param int $code
     * @param string $agent
     * @param string $text
     * @param null|\DateTimeInterface $date
     */
    public function __construct(int $code, string $agent, string $text, \DateTimeInterface $date = null)
    {
        $this->setCode($code);
        $this->setAgent($agent);
        $this->setText($text);
        $this->setDate($date);
    }

    /**
     * Sets the warning code
     *
     * @param int $code
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setCode(int $code) : self
    {
        if (! ($code >= 100 && $code <= 999)) {
            throw new \InvalidArgumentException('The warning code is not valid');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * Sets the warning agent
     *
     * @param string $agent
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setAgent(string $agent) : self
    {
        if (! \preg_match(HeaderInterface::RFC7230_TOKEN, $agent)) {
            throw new \InvalidArgumentException('The warning agent is not valid');
        }

        $this->agent = $agent;

        return $this;
    }

    /**
     * Sets the warning text
     *
     * @param string $text
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    public function setText(string $text) : self
    {
        if (! \preg_match(HeaderInterface::RFC7230_QUOTED_STRING, $text)) {
            throw new \InvalidArgumentException('The warning text is not valid');
        }

        $this->text = $text;

        return $this;
    }

    /**
     * Sets the warning date
     *
     * @param null|\DateTimeInterface $date
     *
     * @return self
     */
    public function setDate(?\DateTimeInterface $date) : self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets the warning code
     *
     * @return int
     */
    public function getCode() : int
    {
        return $this->code;
    }

    /**
     * Gets the warning agent
     *
     * @return string
     */
    public function getAgent() : string
    {
        return $this->agent;
    }

    /**
     * Gets the warning text
     *
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * Gets the warning date
     *
     * @return null|\DateTimeInterface
     */
    public function getDate() : ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldName() : string
    {
        return 'Warning';
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldValue() : string
    {
        $result = \sprintf('%s %s "%s"',
            $this->getCode(),
            $this->getAgent(),
            $this->getText()
        );

        if ($this->getDate() instanceof \DateTimeInterface) {
            $this->getDate()->setTimezone(new \DateTimeZone('GMT'));

            $result .= ' "' . $this->getDate()->format(\DateTime::RFC822) . '"';
        }

        return $result;
    }
}
