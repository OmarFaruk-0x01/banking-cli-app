<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\Model\Money;
use BankingApp\Model\Role;
use BankingApp\State\AuthenticationState;
use BankingApp\View\MessageType;

class Deposit extends Feature
{

    function label(): string
    {
        return "Deposit Money";
    }

    function run(): void
    {
        $amount = (int) $this->view->inputWithValidation("Enter Amount: ",
            fn ($input) =>  ((int) $input) == 0 || (int) $input < 0);

        $money = new Money($amount);
        $this->management
            ->getFinanceManager()
            ->depositMoney($this->authenticationState->getUser(), $money);

        $this->view->renderMessage("Successfully deposit $money", MessageType::Success);
    }

}