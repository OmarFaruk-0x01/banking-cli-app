<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\Model\Role;

class ViewCustomers extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "View Customers";
    }

    function run(): void
    {
        $customers = array_filter($this->management->getAccountsManager()->getAccounts(), fn ($user) => $user->getRole() == Role::CUSTOMER);
        $this->view->renderList($customers,
            fn ($account, $index) => sprintf("%s. $account".PHP_EOL, $index + 1), true);
    }
}