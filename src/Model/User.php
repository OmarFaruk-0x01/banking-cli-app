<?php

namespace BankingApp\Model;

class User
{
    private Money $currentBalance;
    public function __construct(
    private string $name,
    private string $email,
    private string $password,
    private Role $role = Role::CUSTOMER
    )
    {
        $this->password = sha1($password);
        $this->currentBalance = new Money(0);
    }

    public function matchPassword(string $password): bool
    {
        return sha1($password) == $this->password;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Money
     */
    public function getCurrentBalance(): Money
    {
        return $this->currentBalance;
    }

    public function addBalance(Money $money): void
    {
        $this->currentBalance->setAmount($this->currentBalance->getAmount() + $money->getAmount());
    }

    public function lostBalance(Money $money): void
    {
        $this->currentBalance->setAmount($this->currentBalance->getAmount() - $money->getAmount());
    }

    public function __toString(): string
    {
        return "{$this->name} [{$this->email}]";
    }
}