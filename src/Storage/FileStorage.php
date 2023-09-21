<?php

namespace BankingApp\Storage;

readonly class FileStorage implements Storage
{
    private string $folder;
    public function __construct()
    {
        $this->folder = "./db/";
        if (!file_exists($this->folder)){
        mkdir($this->folder);

        }
    }

    function write(string $table ,mixed $obj): void
    {
        file_put_contents($this->getFilePath($table), serialize($obj));
    }

    public function load(string $tableName): mixed
    {
        if (!file_exists($this->getFilePath($tableName))){
            file_put_contents($this->getFilePath($tableName), "");
        }
        $data = file_get_contents($this->getFilePath($tableName));
        if ($data){
            return unserialize($data);
        }

        return null;
    }

    private function getFilePath(string $tableName): string {
        return $this->folder.str_replace("\\", "_", $tableName).'.txt';
    }
}