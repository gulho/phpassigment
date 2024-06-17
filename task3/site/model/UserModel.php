<?php

namespace Model;

class UserModel
{
    private string $username;

    private string $password;

    private int $count;

    /**
     * @param string $username
     * @param string $password
     * @param int $count
     */
    public function __construct(string $username, string $password, int $count = 0)
    {
        $this->username = $username;
        $this->password = $password;
        $this->count = $count;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

}