<?php

namespace BankingApp\Management\Managers;

use BankingApp\Model\User;
use BankingApp\Storage\Storage;

class AccountsManager
{
    /**
     * @var array<User>
     */
    private array $accounts = [];
    public function __construct(private Storage $storage)
    {
    }
    public function addAccount(User $user): void
    {
        $this->accounts[] = $user;
        $this->storage->write(AccountsManager::class, $this);
    }

    /**
     * @return array
     */
    public function getAccounts(): array
    {
        return $this->accounts;
    }

    public function getAccount(string $email): User|null
    {
        foreach ($this->accounts as $account){
            if ($account->getEmail() == $email) return $account;
        }
        return null;
    }
}