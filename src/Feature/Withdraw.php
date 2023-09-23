<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\Model\Money;
use BankingApp\View\MessageType;

class Withdraw extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "Withdraw Money";
    }

    function run(): void
    {
        $amount = (int) $this->view->inputWithValidation("Enter Amount: ",
            fn ($input) =>  ((int) $input) == 0 || (int) $input < 0);

        $money = new Money($amount);
        $this->management
            ->getFinanceManager()
            ->withdrawMoney($this->authenticationState->getUser(), $money);

        $this->view->renderMessage("$money withdrew successful", MessageType::Success);
    }
}