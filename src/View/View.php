<?php

namespace BankingApp\View;


interface View
{
    function preRender();

    public function renderHeader(): void;

    public function renderMessage(string $message, MessageType $type): void;

    /**
     * @param array $list
     * @param \Closure<string> $callback
     * @return void
     */
    public function renderList(array $list, \Closure $callback): void;

    public function getInput(string $placeholder): string;

    public function inputWithValidation(string $placeholder, \Closure $validator, string $message);
}