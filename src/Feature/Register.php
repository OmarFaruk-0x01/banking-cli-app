<?php

namespace BankingApp\Feature;

use BankingApp\Feature\Feature;

class Register extends Feature
{

    /**
     * @inheritDoc
     */
    function label(): string
    {
        return "Register";
    }

    /**
     * @throws \Exception
     */
    function run(): void
    {
        $name = $this->view->getInput("Enter Name: ");
        $email = $this->view->inputWithValidation("Enter Email: ",
            fn ($input) => !filter_var($input, FILTER_VALIDATE_EMAIL), 'Invalid Email!!');
        $password = $this->view->inputWithValidation("Enter Password: ",
            fn ($input) => strlen($input) < 4, 'Minimum 4 character!!');

        $this->authenticationState->register($name, $email, $password);

        $this->view->renderMessage(PHP_EOL."Thank You For register.".PHP_EOL);
    }
}