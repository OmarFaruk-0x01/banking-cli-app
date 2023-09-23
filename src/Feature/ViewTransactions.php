<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\Model\Role;
use BankingApp\Model\TransactionTypes;
use BankingApp\View\MessageType;

class ViewTransactions extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "View Transactions";
    }

    function run(): void
    {
        $transactions = $this->management->getFinanceManager()->getTransactions();
        if (count($transactions) == 0){
            $this->view->renderMessage("No Transactions Found", MessageType::Failed);
        }
        if ($this->authenticationState->getUser()->getRole() == Role::ADMIN){
            $this->view->renderList($transactions,function ($transaction, $index){
                if ($transaction->getTransactionType() == TransactionTypes::TRANSFER){
                    return sprintf("%s. {$transaction->getTransactionType()->name}: {$transaction->getMoney()} [{$transaction->getDate()}] \n\t [{$transaction->getUser()} => {$transaction->getUserTo()}]".PHP_EOL, $index + 1);
                }else{
                    return sprintf("%s. {$transaction->getTransactionType()->name}: {$transaction->getMoney()} [{$transaction->getDate()}] [{$transaction->getUser()}]".PHP_EOL, $index + 1);
                }
            }, true);
            return;
        }

        $deposits = $this->management->getFinanceManager()->getDepositsByUser($this->authenticationState->getUser());
        if (count($deposits) > 0){
            printf("Deposits: ".PHP_EOL);
            $this->view->renderList($deposits,
                fn ($deposits, $index) => sprintf("%s. $deposits".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $withdraws = $this->management->getFinanceManager()->getWithdrawsByUser($this->authenticationState->getUser());
        if (count($withdraws) > 0){
            printf("Withdraws: ".PHP_EOL);
            $this->view->renderList($withdraws,
                fn ($withdraw, $index) => sprintf("%s. $withdraw".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $receives = $this->management->getFinanceManager()->getReceiveTransactionsByUser($this->authenticationState->getUser());
        if (count($receives) > 0){
            printf("Receives: ".PHP_EOL);
            $this->view->renderList($receives,
                fn ($receive, $index) => sprintf("%s. $receive <= {$receive->getUser()}".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }

        $transfers = $this->management->getFinanceManager()->getSentTransactionsByUser($this->authenticationState->getUser());
        if (count($transfers) > 0){
            printf("Transfers: ".PHP_EOL);
            $this->view->renderList($transfers,
                fn ($transfers, $index) => sprintf("%s. $transfers => {$transfers->getUser()}".PHP_EOL, $index + 1),true);
            printf(PHP_EOL);
        }
    }
}