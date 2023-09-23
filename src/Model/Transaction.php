<?php

namespace BankingApp\Model;

use mysql_xdevapi\DatabaseObject;

abstract class Transaction
{
    protected User $user;
    protected Money $money;
    protected User $userTo;
    protected int $timestamp;

    abstract function getTransactionType(): TransactionTypes;

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

    public function getUserTo(): User{
        return $this->userTo;
    }

    public function getDate(): string {
        return date("Y-m-d H:i:s", $this->timestamp);
    }
    public function __toString(): string
    {
        return sprintf("{$this->money} [%s]", $this->getDate());
    }
}