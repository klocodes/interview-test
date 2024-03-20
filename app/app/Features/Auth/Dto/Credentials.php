<?php

namespace App\Features\Auth\Dto;

class Credentials
{
    private string $email;

    private string $password;

    private bool $remember;

    public function __construct(string $email, string $password, bool $remember)
    {
        $this->email = $email;
        $this->password = $password;
        $this->remember = $remember;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function getRemember(): bool
    {
        return $this->remember;
    }
}
