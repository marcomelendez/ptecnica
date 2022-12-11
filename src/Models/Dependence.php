<?php

namespace App\Models;

class Dependence extends Model
{
    /**
     * Obten arbol de dependencia
     *
     * @param string $repositoryId
     * @return array
     */
    public function getAll($repositoryId = ""): array
    {   
        $where = null;

        if($repositoryId){

            $where = "WHERE repositories.id = {$repositoryId}";
        }

        $query = "SELECT repository_main, name as repository_dependence, url_git,repository_id, repository_parent 
            FROM 
            (SELECT repositories.name as repository_main, repository_dependences.repository_id,repository_dependences.repository_parent 
                FROM repository_dependences 
                INNER JOIN repositories ON repository_dependences.repository_id = repositories.id {$where}) as repo_dep 
            INNER JOIN repositories ON repo_dep.repository_parent = repositories.id;";

        return $this->queryRaw($query);     
    }
}