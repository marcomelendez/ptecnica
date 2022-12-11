<?php 
namespace App\Models;

interface IModel
{
    public function insert($table, array $data): void;

    public function queryRaw(String $query): array;
    
}