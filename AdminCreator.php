#!/usr/bin/env php
<?php

require_once "vendor/autoload.php";

$db = new \BankingApp\Storage\FileStorage();
$accountManager = $db->load(\BankingApp\Management\Managers\AccountsManager::class) ?? new \BankingApp\Management\Managers\AccountsManager($db);

$name = readline("Name: ");
$email = readline("Email: ");
$passwod = readline("Password: ");

$user = new \BankingApp\Model\User($name, $email, $passwod, \BankingApp\Model\Role::ADMIN);

$accountManager->addAccount($user);


echo "Admin Created.";