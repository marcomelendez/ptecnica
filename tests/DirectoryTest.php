<?php

namespace Tests;

use App\Repository;
use PHPUnit\Framework\TestCase;

class DirectoryTest extends TestCase
{
    protected $repository;

    public function setUp(): void
    {
        $this->repository = new Repository();
    }

    public function test_create_tree_dependence()
    {
        $dir = __DIR__ . "/fixtures/";

        $result = $this->repository->getTreeRepositories(['repositories/library1'], $dir);

        $this->assertCount(1, $result);

        $repo = [
            0 =>['repositories/library1' => [
                    0 => ['repositories/library4' => []]
                ]
            ]
        ];

        $this->assertSame($repo, $result);
    }

    
}
