<?php

namespace App;

use App\Observer\Pipelines;
use App\Observer\RunTesting;

class Repository
{
    protected $search;

    /**
     * Comprueba las dependencia para determinar que proyectos son afectados con el cambio 
     * informado por un commit.
     *
     * @param string $urlGit
     * @param string $commit
     * @param string $branch
     * @param string $search
     * @return void
     */
    public function run(string $urlGit, string $commit, string $branch, string $search): void
    {
        /**TODO: Debe hacer logica para otener el repositorio que se actualizo por lo pronto es recibido por parametros
         * quizas puedad tomarlo del composer.lock utilizando url del git
         */

        $this->search = $search;

        $arrProjects = Config::PROJECTS;

        $directories = $this->treeDependence($arrProjects);

        $projects = [];

        foreach ($directories as $inx => $directory) {

            $result = false;

            if ($this->existDependence($directory['parent'], $result)) {

                $projects[] = $arrProjects[$inx];
            }
        }

        $this->notifyPipelines($projects);
    }

    /**
     * Undocumented function
     *
     * @param array $projects
     * @return void
     */
    private function notifyPipelines(array $projects)
    {
        /** Toda logica de pipelines */
        $pipelines = new Pipelines();
        $pipelines->attach(new RunTesting($projects));
        $pipelines->notify();
    }

    /**
     * Genera arbol de dependencia
     *
     * @param array $depencendes
     * @return array
     */
    protected function treeDependence(array $depencendes)
    {
        $result = [];

        foreach ($depencendes as $indx => $depen) {

            $dependence = [];

            $result[$indx]['dependence'] = $depen;

            $composer = $this->fileContent($depen);

            if (isset($composer->require)) {

                foreach ($composer->require as $inx => $requires) {

                    if ($this->hasRepository($inx)) {

                        $dependence[$inx] = "{$inx}/$requires";
                        $parent = $this->treeDependence($dependence);

                        $result[$indx]['parent'] = $parent;
                    }
                }
            }
        }

        return $result;
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
    private function existDependence(array $arr,  &$result): bool
    {
        foreach ($arr as $inx => $dat) {

            if ($inx === $this->search) {

                $result = true;
                break;
            }

            if (isset($dat['parent'])) {

                $this->existDependence($dat['parent'], $result);
            }
        }

        return $result;
    }

    /**
     * Comprueba si el repositorio se encuentra en el listado
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
    private function fileContent($dir)
    {
        $directory = __DIR__ . "/../{$dir}/composer.json";
        return json_decode(file_get_contents($directory, true));
    }
}
