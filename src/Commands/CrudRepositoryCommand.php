<?php

namespace Appzcoder\CrudGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudRepositoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:repository
                            {name : The name of the repository.}
                            {--model= : The name of model.}
                            {--searchFields= : The names of the searchable field columns.}
                            {--sortFields= : The names of the sortable field columns.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return config('crudgenerator.custom_template')
            ? config('crudgenerator.path') . '/repository.stub'
            : __DIR__ . '/../stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * Build the repository class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $model = $this->option('model');
        $searchFields = $this->option('searchFields');
        $sortFields = $this->option('sortFields');

        return $this->replaceNamespace($stub, $name)
            ->replaceModel($stub, $model)
            ->replaceSearchFields($stub, $searchFields)
            ->replaceSortFields($stub, $sortFields)
            ->replaceClass($stub, $name);
    }

    /**
     * Replace the model name.
     *
     * @param  string  $stub
     * @param  string  $model
     *
     * @return $this
     */
    protected function replaceModel(&$stub, $model)
    {
        $stub = str_replace(
            '{{model}}', $model, $stub
        );

        return $this;
    }

    /**
     * Replace the search fields for the given stub.
     *
     * @param  string  $stub
     * @param  string  $searchFields
     *
     * @return $this
     */
    protected function replaceSearchFields(&$stub, $searchFields)
    {
        $stub = str_replace(
            '{{searchFields}}', $searchFields, $stub
        );

        return $this;
    }

    /**
     * Replace the sortable field for the given stub.
     *
     * @param  string  $stub
     * @param  string  $sortFields
     *
     * @return $this
     */
    protected function replaceSortFields(&$stub, $sortFields)
    {
        $stub = str_replace(
            '{{sortFields}}', $sortFields, $stub
        );

        return $this;
    }

}
