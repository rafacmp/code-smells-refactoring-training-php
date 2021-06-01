<?php

namespace App\core;

use Exception;

class CannotReadEmployeesException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }

}