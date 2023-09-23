<?php

namespace BankingApp\Model;

use BankingApp\Model\Transaction;

class Transfer extends Transaction
{
    public function __construct(
        protected User $user,
        protected Money $money,
        protected User $userTo
    )
    {
        $this->timestamp = time();
    }

    public function getTransactionType(): TransactionTypes
    {
        return TransactionTypes::TRANSFER;
    }

    /**
     * @return User
     */
    public function getUserTo(): User
    {
        return $this->userTo;
    }

}