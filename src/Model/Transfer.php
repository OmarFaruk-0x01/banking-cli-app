<?php

namespace BankingApp\Model;

use BankingApp\Model\Transaction;

class Transfer extends Transaction
{
    public function __construct(
        private User $user,
        private Money $money,
        private User $userTo
    )
    {
    }

    /**
     * @return User
     */
    public function getUserTo(): User
    {
        return $this->userTo;
    }

}