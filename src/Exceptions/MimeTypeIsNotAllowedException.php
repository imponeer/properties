<?php

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
	protected $mimetype;

	/**
	 * Allowed mimetypes list
	 *
	 * @var array
	 */
	protected $allowed_mimetypes;

	/**
	 * MimeTypeIsNotAllowedException constructor.
	 * @param string $mimetype Current mimetype
	 * @param array $allowed_mimetypes Allowed mimetypes list
	 * @param \Exception $code Code
	 * @param Exception $previous Previous exception
	 */
	public function __construct($mimetype, array $allowed_mimetypes, $code, Exception $previous)
	{
		$this->mimetype = $mimetype;
		$this->allowed_mimetypes = $allowed_mimetypes;

		parent::__construct('Mimetype is not allowed', $code, $previous);
	}

	/**
	 * Get allowed mimetypes list
	 *
	 * @return array
	 */
	public function getAllowedMimetypes()
	{
		return $this->allowed_mimetypes;
	}

	/**
	 * Get current mimetype
	 *
	 * @return string
	 */
	public function getMimetype()
	{
		return $this->mimetype;
	}

}