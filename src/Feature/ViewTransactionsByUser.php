<?php

namespace BankingApp\Feature;

class ViewTransactionsByUser extends Feature
{

    function label(): string
    {
        return "View Transaction By User";
    }

    /**
     * @throws \Exception
     */
    function run(): void
    {
        $email = $this->view->inputWithValidation("Enter Email: ", fn ($input) => !filter_var($input, FILTER_VALIDATE_EMAIL));

        $user = $this->management->getAccountsManager()->getAccount($email);
        if (is_null($user)) {
            throw new \Exception('No User found');
        }

        echo PHP_EOL;

        $deposits = $this->management->getFinanceManager()->getDepositsByUser($user);
        if (count($deposits) > 0){
            printf("Deposits: ".PHP_EOL);
            $this->view->renderList($deposits,
                fn ($deposits, $index) => sprintf("%s. $deposits".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $withdraws = $this->management->getFinanceManager()->getWithdrawsByUser($user);
        if (count($withdraws) > 0){
            printf("Withdraws: ".PHP_EOL);
            $this->view->renderList($withdraws,
                fn ($withdraw, $index) => sprintf("%s. $withdraw".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $receives = $this->management->getFinanceManager()->getReceiveTransactionsByUser($user);
        if (count($receives) > 0){
            printf("Receives: ".PHP_EOL);
            $this->view->renderList($receives,
                fn ($receive, $index) => sprintf("%s. $receive <= {$receive->getUser()}".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $transfers = $this->management->getFinanceManager()->getSentTransactionsByUser($user);
        if (count($transfers) > 0){
            printf("Transfers: ".PHP_EOL);
            $this->view->renderList($transfers,
                fn ($transfers, $index) => sprintf("%s. $transfers => {$transfers->getUserTo()}".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }
    }
}