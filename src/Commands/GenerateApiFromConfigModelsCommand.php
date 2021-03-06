<?php

namespace Jeffersonmartin\Buildhat\Commands;

use Illuminate\Console\Command;

class GenerateApiFromConfigModelsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'buildhat:generate-config-models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD API for all models in config file';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {

        // parent::handle();

        // Get array of models to generate API for
        $models = config('buildhat.models');

        // Get base/root directory of Laravel application
        $base_path = base_path();

        foreach($models as $model_name => $table_name) {

            // Run generator command
            $this->line('<fg=red>Generating API for '.$model_name.' from table '.$table_name.'</>');
            exec('cd '.$base_path.' && php artisan buildhat:api '.$model_name.' --fromTable --tableName='.$table_name);

        }

    }

}
