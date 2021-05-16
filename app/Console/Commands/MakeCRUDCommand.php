<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class MakeCRUDCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD scaffold for model';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = ucfirst($this->argument('model'));
        $pluralModel = str_plural(strtolower($model));

        // model, migration, seeder, factory
        $this->call('make:model', [
            'name' => $model,
            '--migration' => true,
            '--seed' => true,
            '--factory' => true,
        ]);

        // API controller
        $this->call('make:controller', [
            'name' => "{$model}Controller",
            '--model' => $model,
        ]);

        // replace DIRECTORY in controller
        $controllerPath = app_path("Http/Controllers/{$model}Controller.php");

        file_put_contents(
            $controllerPath,
            str_replace('DIRECTORY', $pluralModel, file_get_contents($controllerPath)),
        );

        // policy
        $this->call('make:policy', [
            'name' => "{$model}Policy",
            '--model' => $model,
        ]);

        // create request
        $this->callSilent('make:request', [
            'name' => "Create{$model}Request",
        ]);
        $this->info('Create request created successfully.');

        // update request
        $this->callSilent('make:request', [
            'name' => "Update{$model}Request",
        ]);
        $this->info('Update request created successfully.');

        // creating view files
        File::makeDirectory(resource_path("views/$pluralModel"), 0777, true, true);
        File::put(resource_path("views/$pluralModel/index.blade.php"), '');
        File::put(resource_path("views/$pluralModel/show.blade.php"), '');
        File::put(resource_path("views/$pluralModel/create.blade.php"), '');
        File::put(resource_path("views/$pluralModel/edit.blade.php"), '');
        $this->info('Views created successfully.');

        // register route in routes/api.php
        $route = sprintf("Route::resource('%s', '%sController');", $pluralModel, $model);

        file_put_contents(
            base_path('routes/web.php'),
            $route,
            FILE_APPEND
        );

        $this->info('Route registered successfully.');
    }
}
