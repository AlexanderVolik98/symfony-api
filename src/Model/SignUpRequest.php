<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SignUpRequest implements ModelValidatableInterface
{
    /**
     * @Assert\NotBlank()
     */
    private string $firstName;

    /**
     * @Assert\NotBlank()
     */
    private string $lastName;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private string $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(8)
     */
    private string $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(8)
     */
    private string $confirmPassword;

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }
}
