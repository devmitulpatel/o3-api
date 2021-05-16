<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAPICommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create API scaffold for model';

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

        // model, migration, seeder, factory
        $this->call('make:model', [
            'name'        => $model,
            '--migration' => true,
            '--seed'      => true,
            '--factory'   => true,
        ]);

        // API controller
        $this->call('make:controller', [
            'name'    => "API/{$model}Controller",
            '--model' => $model,
            '--api'   => true,
        ]);

        // policy
        $this->call('make:policy', [
            'name'    => "{$model}Policy",
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

        // eloquent resource
        $this->call('make:resource', [
            'name' => "{$model}Resource",
        ]);

        // register route in routes/api.php
        $route = sprintf("Route::apiResource('%s', '%sController');", str_plural(strtolower($model)), $model);

        file_put_contents(
            base_path('routes/api.php'),
            $route,
            FILE_APPEND
        );

        $this->info('Route registered successfully.');
    }
}
