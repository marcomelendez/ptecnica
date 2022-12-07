<?php

namespace App\Observer;

use SplObserver;
use SplSubject;

class RunTesting implements SplObserver
{   
    private $repositories = [];

    public function __construct(array $repositories)
    {
        $this->repositories = $repositories;
    }

    public function update(SplSubject $subject): void
    {
        foreach($this->repositories as $repo){

            echo "Test para : ". $repo. "...\n";
        }
    }   
}