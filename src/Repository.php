<?php

namespace App;

use App\Observer\Pipelines;
use App\Observer\RunTesting;

class Repository 
{
    public function run($urlGit, $commit, $branch, $repo = null)
    {
        /**TODO: Debe hacer logica para otener el repositorio que se actualizo por lo pronto es recibido por parametros
         * quizas puedad tomarlo del composer.lock utilizando url del git
         */
        
        $dependenceRepository = $this->getDependenceRepository($repo, Config::PROJECTS);

        /** Toda logica de pipelines */
        $pipelines = new Pipelines();
        $pipelines->attach(new RunTesting($dependenceRepository));
        $pipelines->notify();
    }

    public function getDependenceRepository($repo, array $arrProjects): array
    {
        $directories = $this->getTreeRepositories($arrProjects);
        $projects = [];

        foreach($directories as $inx =>$directory){
            
            $result = false;

            if($this->hasRelations($directory, $repo, $result)){

                $projects[] = $arrProjects[$inx];
            }
        }

        return $projects;
    }
    
    /**
     * Recorre arbol de repositorios para obtener relacion
     * 
     * @param array $arr
     * @param string $repo
     * @param boolean &$result
     * 
     * @return mixed
     */

    private function hasRelations(array $arr, $repo, &$result)
    {   
        foreach($arr as $inx => $dat){

            if($inx === $repo) {

                $result = true;
                break;
            }else{
      
                $this->hasRelations($dat, $repo,$result);
            }
        }

        return $result;
    }

    /**
     * Crear arbol de repositorios
     *
     * @param array $directories
     * @return array
     */
    public function getTreeRepositories(array $directories, $path = "")
    {
        foreach ($directories as $dir) {
            
            $treeDependency[] = $this->getTreeDependency($dir, $path);
        }
        
        return $treeDependency;
    }

    /**
     * Arbol de dependencia de un repositorio
     *
     * @param [type] $name
     * @return array
     */
    private function getTreeDependency($name = null, $path = "")
    {
        $path = $path ? $path :  __DIR__ . "/../";

        $fileContent = $this->fileContent("{$path}{$name}/composer.json");

        $nameLibrary = $name ?? $fileContent->name;
        $result = [];
        
        if ($this->hasRepository($nameLibrary)) {

            $result[$nameLibrary] = [];
            
            if (isset($fileContent->require)) {

                foreach ($fileContent->require as $inx => $requires){
                   
                    if ($this->hasRepository($inx)){

                        $result[$nameLibrary][] = $this->getTreeDependency($inx, $path);
                    }
                }
            }
        }

        return $result;
    }
    
    /**
     * Comprueba listado de Repositorios permitidos
     *
     * @param string $name
     * @return boolean
     */
    private function hasRepository($name)
    {
        return in_array($name, Config::DIRECTORIES) || in_array($name, Config::PROJECTS);
    }

    /**
     * Comprueba el contenido del directorio
     *
     * @param string $dir
     * @return StdClass
     */
    private function fileContent($dir = null)
    {
        $directory = !empty($dir) ? $dir : __DIR__ . "/../composer.json";
        return json_decode(file_get_contents($directory, true));
    }
}
