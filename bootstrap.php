<?php

use App\Repository;

require __DIR__. '/vendor/autoload.php';


$urlGit   = $argv[1];
$commitId = $argv[2];
$branch   = $argv[3];
$repo     = $argv[4];

$directories = new Repository();
print_r($directories->run($urlGit,$commitId,$branch,$repo));