<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;
use BankingApp\State\AuthenticationState;

class Login extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "Login";
    }

    /**
     * @throws \Exception
     */
    function run(): void
    {
        $email = $this->view->inputWithValidation("Enter Email: ",
                fn ($input) => !filter_var($input, FILTER_VALIDATE_EMAIL), 'Invalid Email!!');
        $password = $this->view->inputWithValidation("Enter Password: ",
                fn ($input) => strlen($input) < 4, 'Minimum 4 character!!');

        $this->authenticationState->login($email, $password);
        $this->storage->write(AuthenticationState::class, $this->authenticationState);
    }
}