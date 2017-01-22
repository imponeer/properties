<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 8:23 PM
 */

namespace IPFLibraries\Properties\CommonProperties;


class Docxode extends Doxcode
{

	public function __construct()
	{
		trigger_error('You should use doxcode in code. Not docxode.', E_USER_WARNING);
	}

}