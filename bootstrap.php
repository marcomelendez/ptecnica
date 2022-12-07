<?php

require __DIR__. '/vendor/autoload.php';

use App\Repository;

$urlGit   = $argv[1];
$commitId = $argv[2];
$branch   = $argv[3];
$repo     = $argv[4];

$repositories = new Repository();
$repositories->run($urlGit,$commitId,$branch,$repo);

