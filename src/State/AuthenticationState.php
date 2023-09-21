<?php

namespace BankingApp\State;

use BankingApp\Management\Managers\AccountsManager;
use BankingApp\Model\Role;
use BankingApp\Model\User;

class AuthenticationState
{
    private User|null $user;
    private bool $isAuthenticated;
    public function __construct(private readonly AccountsManager $accountsManager)
    {
        $this->user = new User("Guest", "", "", Role::GUEST);
        $this->isAuthenticated = false;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


    public function isLoggedIn(): bool
    {
        return $this->isAuthenticated;
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     * @throws \Exception
     */
    public function login(string $email, string $password): void
    {
        $user = $this->accountsManager->getAccount($email);
        if ($user && $user->matchPassword($password)){
            $this->user = $user;
            $this->isAuthenticated = true;
            return;
        }
        throw new \Exception("invalid credentials");
    }


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return void
     * @throws \Exception
     */
    public function register(string $name, string $email, string $password): void
    {
        $user = $this->accountsManager->getAccount($email);
        if (!is_null($user)){
            throw new \Exception("Email already taken");
        }
        $user = new User($name, $email, $password);
        $this->accountsManager->addAccount($user);
    }


}