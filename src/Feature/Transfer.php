<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\Model\Money;
use BankingApp\View\MessageType;

class Transfer extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "Transfer Money";
    }

    function run(): void
    {
        $amount = (int) $this->view->inputWithValidation("Enter Amount: ",
            fn ($input) =>  ((int) $input) == 0 || (int) $input < 0);

        $email = $this->view->inputWithValidation("Enter Receiver Email: ",
            fn ($input) => !filter_var($input, FILTER_VALIDATE_EMAIL));

        $userTo = $this->management
            ->getAccountsManager()
            ->getAccount($email);

        while (is_null($userTo)){
            $this->view->renderMessage("No User Found".PHP_EOL, MessageType::Failed);
            $email = (int) $this->view->inputWithValidation("Enter Receiver Email: ",
                fn ($input) => !filter_var($input, FILTER_VALIDATE_EMAIL));

            $userTo = $this->management
                ->getAccountsManager()
                ->getAccount($email);
        }

        $money = new Money($amount);
        $this->management
            ->getFinanceManager()
            ->transferMoney($this->authenticationState->getUser(), $money, $userTo);

        $this->view->renderMessage("$money successfully transferred to $userTo", MessageType::Success);
    }
}