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
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use Traversable;

/**
 * Import functions
 */
use function gettype;
use function is_int;
use function is_string;
use function preg_match;
use function sprintf;

/**
 * AbstractHeader
 */
abstract class AbstractHeader implements HeaderInterface
{

    /**
     * {@inheritdoc}
     */
    final public function __toString() : string
    {
        return sprintf('%s: %s', $this->getFieldName(), $this->getFieldValue());
    }

    /**
     * {@inheritdoc}
     */
    final public function getIterator() : Traversable
    {
        return new ArrayIterator([$this->getFieldName(), $this->getFieldValue()]);
    }

    /**
     * Gets Regular Expression for a token validation
     *
     * @return string
     */
    protected function getTokenValidationRegularExpression() : string
    {
        return HeaderInterface::RFC7230_TOKEN;
    }

    /**
     * Gets Regular Expression for a parameter name validation
     *
     * @return string
     */
    protected function getParameterNameValidationRegularExpression() : string
    {
        return HeaderInterface::RFC7230_TOKEN;
    }

    /**
     * Gets Regular Expression for a parameter value validation
     *
     * @return string
     */
    protected function getParameterValueValidationRegularExpression() : string
    {
        return HeaderInterface::RFC7230_QUOTED_STRING;
    }

    /**
     * Checks if the given string is token
     *
     * @param string $token
     *
     * @return bool
     */
    final protected function isToken(string $token) : bool
    {
        return preg_match($this->getTokenValidationRegularExpression(), $token) === 1;
    }

    /**
     * Validates the given token(s)
     *
     * @param string ...$tokens
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If one of the tokens isn't valid.
     */
    final protected function validateToken(string ...$tokens) : void
    {
        foreach ($tokens as $token) {
            if (!$this->isToken($token)) {
                throw new InvalidArgumentException(sprintf(
                    'The value "%2$s" for the header "%1$s" is not valid',
                    $this->getFieldName(),
                    $token
                ));
            }
        }
    }

    /**
     * Validates the given quoted string(s)
     *
     * @param string ...$quotedStrings
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If one of the quoted strings isn't valid.
     */
    final protected function validateQuotedString(string ...$quotedStrings) : void
    {
        foreach ($quotedStrings as $quotedString) {
            if (!preg_match(HeaderInterface::RFC7230_QUOTED_STRING, $quotedString)) {
                throw new InvalidArgumentException(sprintf(
                    'The value "%2$s" for the header "%1$s" is not valid',
                    $this->getFieldName(),
                    $quotedString
                ));
            }
        }
    }

    /**
     * Validates and normalizes the given parameters
     *
     * @param array<array-key, mixed> $parameters
     *
     * @return array
     *
     * @throws InvalidArgumentException
     *         If one of the parameters isn't valid.
     */
    final protected function validateParameters(array $parameters) : array
    {
        foreach ($parameters as $name => $value) {
            // e.g. Cache-Control: max-age=31536000
            if (is_int($value)) {
                $parameters[$name] = $value = (string) $value;
            }

            if (!is_string($name) || !preg_match($this->getParameterNameValidationRegularExpression(), $name)) {
                throw new InvalidArgumentException(sprintf(
                    'The parameter-name "%2$s" for the header "%1$s" is not valid',
                    $this->getFieldName(),
                    (is_string($name) ? $name : ('<' . gettype($name) . '>'))
                ));
            }

            /** @psalm-suppress MixedArgument */
            if (!is_string($value) || !preg_match($this->getParameterValueValidationRegularExpression(), $value)) {
                throw new InvalidArgumentException(sprintf(
                    'The parameter-value "%2$s" for the header "%1$s" is not valid',
                    $this->getFieldName(),
                    (is_string($value) ? $value : ('<' . gettype($value) . '>'))
                ));
            }
        }

        return $parameters;
    }

    /**
     * Validates the given header field-name
     *
     * @param mixed $fieldName
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If the header field-name isn't valid.
     */
    final protected function validateFieldName($fieldName) : void
    {
        if (!is_string($fieldName)) {
            throw new InvalidArgumentException('Header field-name must be a string');
        }

        if (!preg_match(HeaderInterface::RFC7230_TOKEN, $fieldName)) {
            throw new InvalidArgumentException('Header field-name is invalid');
        }
    }

    /**
     * Validates the given header field-value
     *
     * @param mixed $fieldValue
     *
     * @return void
     *
     * @throws InvalidArgumentException
     *         If the header field-value isn't valid.
     */
    final protected function validateFieldValue($fieldValue) : void
    {
        if (!is_string($fieldValue)) {
            throw new InvalidArgumentException('Header field-value must be a string');
        }

        // a header's field value can be empty...
        if ($fieldValue === '') {
            return;
        }

        if (!preg_match(HeaderInterface::RFC7230_FIELD_VALUE, $fieldValue)) {
            throw new InvalidArgumentException('Header field-value is invalid');
        }
    }

    /**
     * Normalizes the given date-time object
     *
     * @param T $dateTime
     *
     * @return T
     *
     * @template T as DateTimeInterface
     */
    final protected function normalizeDateTime(DateTimeInterface $dateTime) : DateTimeInterface
    {
        if ($dateTime instanceof DateTime) {
            return (clone $dateTime)->setTimezone(new DateTimeZone('GMT'));
        }

        if ($dateTime instanceof DateTimeImmutable) {
            return $dateTime->setTimezone(new DateTimeZone('GMT'));
        }

        // @codeCoverageIgnoreStart
        return $dateTime;
        // @codeCoverageIgnoreEnd
    }

    /**
     * Formats the given date-time object
     *
     * @param DateTimeInterface $dateTime
     *
     * @return string
     *
     * @link https://datatracker.ietf.org/doc/html/rfc822
     */
    final protected function formatDateTime(DateTimeInterface $dateTime) : string
    {
        return $this->normalizeDateTime($dateTime)->format(DateTime::RFC822);
    }
}
