<?php

namespace BankingApp\Model;

enum TransactionTypes: string
{
    case DEPOSIT = "Deposit";
    case WITHDRAW = "Withdraw";
    case TRANSFER = "Transfer";
}
