<?php

namespace BankingApp\Management;

use BankingApp\Management\Managers\AccountsManager;
use BankingApp\Management\Managers\FinanceManager;

class Management
{
    public function __construct(
        private readonly FinanceManager  $financeManager,
        private readonly AccountsManager $accountsManager,
    )
    {
    }

    /**
     * @return AccountsManager
     */
    public function getAccountsManager(): AccountsManager
    {
        return $this->accountsManager;
    }

    /**
     * @return FinanceManager
     */
    public function getFinanceManager(): FinanceManager
    {
        return $this->financeManager;
    }

}