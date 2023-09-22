<?php

namespace BankingApp\View;

use BankingApp\Management\Management;
use BankingApp\State\AuthenticationState;

readonly class ConsoleView implements View
{
    public function __construct(private AuthenticationState $state, private Management $management)
    {
    }

    public function preRender(): void
    {
        system("clear");
    }

    private function renderBar(): void
    {
        printf(str_repeat("=", 20).PHP_EOL);
    }

    public function renderHeader(): void
    {
        if (!$this->state->isLoggedIn()){
            $this->renderBar();
            printf("Login Required".PHP_EOL);
            $this->renderBar();
        }else{
            $this->renderBar();
            printf("Name    : {$this->state->getUser()->getName()}".PHP_EOL);
            printf("Email   : %s".PHP_EOL, $this->state->isFirstRun() ? $this->hideEmail($this->state->getUser()->getEmail()) : $this->state->getUser()->getEmail());
            printf("Balance : %s".PHP_EOL, $this->state->isFirstRun() ? "****" : $this->state->getUser()->getCurrentBalance());
            $this->renderBar();
        }
    }

    public function renderMessage(string $message, MessageType $type = MessageType::Normal): void
    {
        if ($type == MessageType::Success) {
            $message = "[√] $message";
        } else if ($type == MessageType::Failed) {
            $message = "[x] $message";
        }
        printf($message);
    }


    public function renderList($list, $callback): void
    {
        foreach ($list as $key => $item) {
            $this->renderMessage($callback($item, $key));
        }
    }

    public function getInput($placeholder): string
    {
        return readline($placeholder);
    }

    public function inputWithValidation(string $placeholder, \Closure $validator, string $message = "Wrong input!!"): string
    {
        $input = $this->getInput($placeholder);
        while ($validator($input)) {
            $this->renderMessage("$message\n", MessageType::Failed);
            $input = $this->getInput($placeholder);
        }
        return $input;
    }

    private function hideEmail(string $email): string {
        $username = explode("@", $email)[0];

        return str_replace(join('', array_slice(str_split($username), 0, strlen($username) - 2)), "****", $email);
}
}