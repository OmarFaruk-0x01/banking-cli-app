<?php

namespace BankingApp\Management\Managers;

use BankingApp\Model\Deposit;
use BankingApp\Model\Money;
use BankingApp\Model\Transaction;
use BankingApp\Model\TransactionTypes;
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
        $this->storage->write(FinanceManager::class, $this);
    }

    public function withdrawMoney(User $user, Money $money): void
    {
        $this->transactions[] = new Withdraw($user, $money);
        $user->lostBalance($money);
        $this->storage->write(FinanceManager::class, $this);
    }

    public function transferMoney(User $userFrom, Money $money, User $userTo): void
    {
        $this->transactions[] = new Transfer($userFrom, $money, $userTo);
        $userFrom->lostBalance($money);
        $userTo->addBalance($money);
        $this->storage->write(FinanceManager::class, $this);
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

    public function getDepositsByUser(User $user): array
    {
        return array_filter($this->transactions,
            fn ($transaction) => $transaction->getTransactionType() == TransactionTypes::DEPOSIT && $transaction->getUser()->getEmail() === $user->getEmail());
    }

    public function getWithdrawsByUser(User $user): array
    {
        return array_filter($this->transactions,
            fn ($transaction) => $transaction->getTransactionType() == TransactionTypes::WITHDRAW && $transaction->getUser()->getEmail() === $user->getEmail());
    }
    public function getReceiveTransactionsByUser(User $user): array
    {
        return array_filter($this->transactions,
            fn ($transaction) => $transaction->getTransactionType() == TransactionTypes::TRANSFER && $transaction->getUserTo()->getEmail() === $user->getEmail());
    }

    public function getSentTransactionsByUser(User $user): array
    {
        return array_filter($this->transactions,
            fn ($transaction) => $transaction->getTransactionType() == TransactionTypes::TRANSFER && $transaction->getUser()->getEmail() === $user->getEmail());
    }
    public function getBalanceByUser(User $user): Money
    {
        $totalWithdraw = $this->getTotalAmount($this->getWithdrawsByUser($user));

        $totalDeposit = $this->getTotalAmount($this->getDepositsByUser($user));

        $totalReceived = $this->getTotalAmount($this->getReceiveTransactionsByUser($user));

        $totalSent = $this->getTotalAmount($this->getSentTransactionsByUser($user));

        return new Money(($totalDeposit + $totalReceived) - ($totalWithdraw + $totalSent));
    }

    private function getTotalAmount(array $transactions): int{
        return array_reduce($transactions,
            fn ($acc, $crr) => $acc + $crr->getMoney()->getAmount(), 0);
}
}