<?php

namespace BankingApp\Model;

abstract class Transaction
{
    private User $user;
    private Money $money;

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}