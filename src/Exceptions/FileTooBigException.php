<?php

namespace Imponeer\Properties\Exceptions;

/**
 * Exception thrown when file is too big
 *
 * @package Imponeer\Properties\Exceptions
 */
class FileTooBigException extends \Exception
{

	/**
	 * Max file size
	 *
	 * @var double
	 */
	protected $max_size;

	/**
	 * Current file size
	 *
	 * @var double
	 */
	protected $current_size;

	/**
	 * Source
	 *
	 * @var string
	 */
	protected $src;

	/**
	 * FileTooBigException constructor.
	 *
	 * @param string $src Source
	 * @param double $max_size Max file size
	 * @param double $current_size Current file size
	 * @param int $code Code
	 * @param \Exception $previous Previous exception
	 */
	public function __construct($src, $max_size, $current_size, $code, Exception $previous)
	{
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
	public function getSize()
	{
		return $this->current_size;
	}

	/**
	 * Get maximum filesize allowed
	 *
	 * @return float
	 */
	public function getMaxSize()
	{
		return $this->max_size;
	}

	/**
	 * Get source what was checked for filesize
	 *
	 * @return string
	 */
	public function getSource()
	{
		return $this->src;
	}

}