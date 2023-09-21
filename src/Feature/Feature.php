<?php

namespace BankingApp\Feature;

use BankingApp\Management\Management;
use BankingApp\Model\Role;
use BankingApp\State\AuthenticationState;
use BankingApp\Storage\Storage;
use BankingApp\Traits\RepeatAskingInput;
use BankingApp\View\View;

abstract class Feature
{
    public function __construct(protected AuthenticationState $authenticationState, protected Management $management, protected View $view, protected Storage $storage)
    {
    }

    /**
     * @return array<Role>
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
    }

    public function __toString(): string
    {
        return $this->label();
    }
}