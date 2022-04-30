<?php

namespace App\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException
{
    private ConstraintViolationListInterface $violatios;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violatios = $violations;

        parent::__construct('validation failed');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violatios;
    }
}