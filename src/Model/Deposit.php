<?php

namespace BankingApp\Model;

class Deposit extends Transaction
{
    public function __construct(protected User $user, protected Money $money)
    {
        $this->timestamp = time();
    }

    public function getTransactionType(): TransactionTypes
    {
        return TransactionTypes::DEPOSIT;
    }
}