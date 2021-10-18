<?php

namespace App\Exceptions;

use Exception;

class DataBaseErrorException extends Exception
{
    // ...

    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['domainName' => $this->domainName];
    }
}