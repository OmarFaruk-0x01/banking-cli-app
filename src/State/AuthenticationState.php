<?php

namespace BankingApp\State;

use BankingApp\Management\Managers\AccountsManager;
use BankingApp\Model\Role;
use BankingApp\Model\User;

class AuthenticationState
{
    private User|null $user;
    private bool $isFirstRun;
    private bool $isAuthenticated;
    public function __construct(private readonly AccountsManager $accountsManager)
    {
        $this->user = new User("Guest", "", "", Role::GUEST);
        $this->isAuthenticated = false;
        $this->isFirstRun = true;
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

    public function isFirstRun(): bool
    {
        return $this->isFirstRun;
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
            $this->isFirstRun = false;
            return;
        }
        throw new \Exception("invalid credentials");
    }

    /**
     * @throws \Exception
     */
    public function reLogin(string $password): void
    {
        if ($this->user->matchPassword($password)){
            $this->isFirstRun = false;
        }
        else{
            throw new \Exception('invalid credentials');
        }
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

    public function logout(): void
    {
        $this->user = new User('Guest', "", "", Role::GUEST);
        $this->isAuthenticated = false;
    }

    public function __sleep(): array
    {
        return [
            "user",
            "isAuthenticated",
        ];
    }

    public function __wakeup(): void
    {
        $this->isFirstRun = true;
    }

}