<?php

namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class ErrorResponse
{
    private $message;
    private $details;

    public function __construct($message, $details = null)
    {
        $this->message = $message;
        $this->details = $details;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @OA\Property(type="object", oneOf={
     *     @OA\Schema(ref=@Model(type=ErrorDebugDetails::class)),
     *     @OA\Schema(ref=@Model(type=ErrorValidationDetails::class)),
     *     })
     */
    public function getDetails()
    {
        return $this->details;
    }
}
