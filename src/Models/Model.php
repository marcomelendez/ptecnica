<?php

namespace App\Models;

use PDO;
use PDOException;

class Model implements IModel
{
    const HOSTS = "mysql";
    const DATABASE = "development";
    const USER  = "root";
    const PASS  = "root";

    protected $db;

    public function __construct()
    {
        $host = self::HOSTS;
        $dbName = self::DATABASE;

        try {

            $dsn = "mysql:host={$host};dbname={$dbName}";
            $this->db = new PDO($dsn, self::USER, self::PASS);

        } catch (PDOException $e){
 
            echo $e->getMessage(); exit;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $table
     * @param array $data
     * @return void
     */
    public function insert($table, array $data): void
    {
        $column = implode(",", array_keys($data));
        $values = implode(",", $this->prepareValues($data));

        $query = "INSERT INTO {$table} ({$column}) VALUES ({$values})";
        
        $prepare = $this->db->prepare($query);

        foreach($data as $inx => $val){
            
            $prepare->bindValue(":{$inx}", $val);
        }

        $prepare->execute();
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @return array
     */
    private function prepareValues($data): array
    {
        $values = [];

        foreach($data as  $inx =>$val){
          
            $values[] = ":{$inx}";
        }

        return $values;
    }

    /**
     * Undocumented function
     *
     * @param String $query
     * @return array
     */
    public function queryRaw(String $query): array
    {
        $prepare = $this->db->prepare($query);
        $prepare->execute();

        return $prepare->fetchAll(PDO::FETCH_ASSOC);
    }
}    
