<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\State\AuthenticationState;

class Logout extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "Logout";
    }

    function run(): void
    {
        $this->authenticationState->logout();
        $this->storage->write(AuthenticationState::class, $this->authenticationState);
    }
}