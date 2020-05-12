<?php

namespace App\Exceptions;

use Exception;
use App\Models\Support;

class SupportIsBusyException extends Exception
{
    private Support $support;

    public function __construct(Support $support)
    {
        $this->support = $support;
    }
}
