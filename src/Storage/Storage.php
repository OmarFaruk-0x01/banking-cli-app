<?php

namespace BankingApp\Storage;

interface Storage
{
    function write(string $tableName, mixed $state): void;

    function load(string $tableName): mixed;
}