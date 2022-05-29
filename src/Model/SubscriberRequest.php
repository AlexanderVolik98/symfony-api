<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SubscriberRequest implements ModelValidatableInterface
{
    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private string $email;

    /**
     * @Assert\NotBlank()
     * @Assert\IsTrue()
     */
    private bool $agreed;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function isAgreed(): bool
    {
        return $this->agreed;
    }

    public function setAgreed(bool $agreed): void
    {
        $this->agreed = $agreed;
    }
}