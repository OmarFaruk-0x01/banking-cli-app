<?php

namespace BankingApp\Model;

class Withdraw extends Transaction
{
    public function __construct(private User $user, private Money $money)
    {
    }
}