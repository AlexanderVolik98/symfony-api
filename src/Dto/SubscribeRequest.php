<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

class SubscribeRequest implements RequestDTO
{
    private ?string $email;
    private bool $agreed;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getAgreed()
    {
        return $this->agreed;
    }

    public function setAgreed($agreed): void
    {
        $this->agreed = $agreed;
    }

    public function __construct(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $this->email = $data['email'] ?? null;
        $this->agreed = $data['agreed'] ?? false;
    }
}