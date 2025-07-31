<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * Exception thrown when file is too big
 *
 * @package Imponeer\Properties\Exceptions
 */
class FileTooBigException extends Exception
{
    /**
     * Max file size
     *
     * @var float
     */
    protected float $max_size;

    /**
     * Current file size
     *
     * @var float
     */
    protected float $current_size;

    /**
     * Source
     *
     * @var string
     */
    protected string $src;

    /**
     * FileTooBigException constructor.
     *
     * @param string $src Source
     * @param float $max_size Max file size
     * @param float $current_size Current file size
     * @param int $code Code
     * @param Throwable|null $previous Previous exception
     */
    public function __construct(
        string $src,
        float $max_size,
        float $current_size,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        $this->max_size = $max_size;
        $this->current_size = $current_size;
        $this->src = $src;

        parent::__construct('File too big!', $code, $previous);
    }

    /**
     * Return current file size
     *
     * @return float
     */
    public function getSize(): float
    {
        return $this->current_size;
    }

    /**
     * Get maximum filesize allowed
     *
     * @return float
     */
    public function getMaxSize(): float
    {
        return $this->max_size;
    }

    /**
     * Get source what was checked for filesize
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->src;
    }
}
