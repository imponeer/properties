<?php

declare(strict_types=1);

namespace Imponeer\Properties\CommonProperties;

class Docxode extends Doxcode
{
    public function __construct()
    {
        trigger_error('You should use doxcode in code. Not docxode.', E_USER_WARNING);
    }
}
