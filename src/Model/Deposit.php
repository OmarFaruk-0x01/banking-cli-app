<?php

namespace BankingApp\Model;

class Deposit extends Transaction
{
    public function __construct(private User $user, private Money $money)
    {
    }
}