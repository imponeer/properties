<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

/**
 * This exception is throw when mimetype is not allowed
 *
 * @package Imponeer\Properties\Exceptions
 */
class MimeTypeIsNotAllowedException extends \Exception
{
    /**
     * Current file mimetype
     *
     * @var string
     */
    protected string $mimetype;

    /**
     * Allowed mimetypes list
     *
     * @var string[]
     */
    protected array $allowed_mimetypes;

    /**
     * MimeTypeIsNotAllowedException constructor.
     * @param string $mimetype Current mimetype
     * @param string[] $allowed_mimetypes Allowed mimetypes list
     * @param int $code Code
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(string $mimetype, array $allowed_mimetypes, int $code = 0, ?\Throwable $previous = null)
    {
        $this->mimetype = $mimetype;
        $this->allowed_mimetypes = $allowed_mimetypes;

        parent::__construct('Mimetype is not allowed', $code, $previous);
    }

    /**
     * Get allowed mimetypes list
     *
     * @return string[]
     */
    public function getAllowedMimetypes(): array
    {
        return $this->allowed_mimetypes;
    }

    /**
     * Get current mimetype
     *
     * @return string
     */
    public function getMimetype(): string
    {
        return $this->mimetype;
    }
}
