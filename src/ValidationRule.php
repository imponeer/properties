<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 7:38 PM
 */

namespace IPFLibraries\Properties;

/**
 * Predefined validation rules
 *
 * @package IPFLibraries\Properties
 */
class ValidationRule
{
	/**
	 * Validation rule for emails
	 */
	const EMAIL = '/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i';

	/**
	 * Validation rule for links
	 */
	const LINKS = '#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i';
}