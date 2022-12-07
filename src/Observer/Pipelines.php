<?php

namespace App\Observer;

use SplObserver;

class Pipelines implements \SplSubject
{
    private $observers = [];

    public function __construct($event = "*")
    {   
        $this->observers[$event] = [];
    }

    public function attach(SplObserver $observer,string $event = "*"): void
    {
        $this->observers[$event][] = $observer;
    }

    public function detach(SplObserver $observer, $event = "*"): void
    {
        foreach($this->observers[$event] as $key => $obs){

            if($obs === $observer){

                unset($this->observers[$event][$key]);
            }
        }
    }

    public function notify(string $event = "*",$data = null): void
    {
        foreach($this->observers[$event] as $observer){
            $observer->update($this, $event, $data);
        }
    }
    
}