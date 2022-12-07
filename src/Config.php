<?php 

namespace App;

abstract class Config
{
    const REPOSITORY = 'repositories';

    const PROJECTS = [
        self::REPOSITORY.'/proyecto1',
        self::REPOSITORY.'/proyecto2',
    ];

    const DIRECTORIES = [
        self::REPOSITORY. '/library1',
        self::REPOSITORY.'/library2',
        self::REPOSITORY.'/library4'
    ];

}