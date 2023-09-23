<?php

namespace BankingApp\View;


interface View
{
    function preRender();

    public function renderHeader(): void;

    public function renderMessage(string $message, MessageType $type): void;

    /**
     * @param array $list
     * @param Callable $callback
     * @return void
     */
    public function renderList(array $list, Callable $callback, bool $withIndex): void;

    public function getInput(string $placeholder): string;

    public function inputWithValidation(string $placeholder, \Closure $validator, string $message);
}