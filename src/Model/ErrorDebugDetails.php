<?php

namespace App\Model;

class ErrorDebugDetails
{
    private string $trace;

    public function getTrace(): string
    {
        return $this->trace;
    }

    public function __construct($trace)
    {
        $this->trace = $trace;
    }
}