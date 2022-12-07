<?php

namespace Tests;

use App\Observer\Pipelines;
use App\Observer\RunTesting;
use PHPUnit\Framework\TestCase;
use SplSubject;

class PipelineTest extends TestCase
{
    protected $pipeline;

    public function setUp(): void
    {
        $this->pipeline = new Pipelines();
    }

    public function test_type_of_clase()
    {
        $this->assertInstanceOf(\SplSubject::class, $this->pipeline);
    }

    public function test_create_listener()
    {
        $this->pipeline->attach(new RunTesting(['repository1']));
        $result = $this->pipeline->notify();

        $this->assertTrue(print_r($result));
    }
}
