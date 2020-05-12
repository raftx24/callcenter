<?php

namespace App\Exceptions;

use Exception;
use App\Models\Call;

class CallIsNotImmediateException extends Exception
{
    private Call $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }
}
