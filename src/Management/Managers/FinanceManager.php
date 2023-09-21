<?php

namespace BankingApp\Management\Managers;

use BankingApp\Model\Deposit;
use BankingApp\Model\Money;
use BankingApp\Model\Transaction;
use BankingApp\Model\Transfer;
use BankingApp\Model\User;
use BankingApp\Model\Withdraw;
use BankingApp\Storage\Storage;

class FinanceManager
{
    /**
     * @var array<Transaction>
     */
    private array $transactions = [];

    public function __construct(private Storage $storage)
    {
    }

    public function depositMoney(User $user, Money $money): void
    {
        $this->transactions[] = new Deposit($user, $money);
        $user->addBalance($money);
    }

    public function withdrawMoney(User $user, Money $money): void
    {
        $this->transactions[] = new Withdraw($user, $money);
        $user->lostBalance($money);
    }

    public function transferMoney(User $userFrom, Money $money, User $userTo): void
    {
        $this->transactions[] = new Transfer($userFrom, $money, $userTo);
        $userFrom->lostBalance($money);
        $userTo->addBalance($money);
    }

    /**
     * @return array<Transaction>
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * @param string $email
     * @return array<Transaction>
     */
    public function getTransactionsByUser(string $email): array
    {
        return array_filter($this->transactions, fn ($transaction) => $transaction->getUser()->getEmail() == $email);
    }
}