<?php

namespace BankingApp\Feature;

use BankingApp\Management\Management;
use BankingApp\Model\Role;
use BankingApp\Model\User;
use BankingApp\State\AuthenticationState;
use BankingApp\Storage\Storage;
use BankingApp\View\View;

abstract class Feature
{
    protected User $loggedInUser;
    public function __construct(protected AuthenticationState $authenticationState, protected Management $management, protected View $view, protected Storage $storage)
    {
    }

    /**
     * @return string
     */
    abstract function label(): string;

    function preRun(): void
    {
        printf("\n$$ {$this->label()} $$\n\n");
    }

    abstract function run(): void;

    function postRun(): void
    {
        printf("\n");
        $this->storage->write(AuthenticationState::class, $this->authenticationState);
    }

    public function __toString(): string
    {
        return $this->label();
    }
}