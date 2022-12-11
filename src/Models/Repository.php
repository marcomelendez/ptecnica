<?php

namespace App\Models;

class Repository extends Model
{
    public function getAll()
    {
        $query = "SELECT * FROM repositories";
        return $this->queryRaw($query);
    }

    public function hasRepository($name, $url)
    {
        $query = "SELECT * FROM repositories WHERE name LIKE %{$name}% AND url_git = {$url}";
        return $this->queryRaw($query);
    }
}