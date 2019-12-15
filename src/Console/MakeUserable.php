<?php

namespace Majebry\LaravelUserable\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeUserable extends Command
{
    protected $signature = 'userable:make {usertype}';

    protected $description = 'Make Userable';

    protected $name;

    public function handle()
    {
        $name = $this->argument('usertype');
        

        $this->info('Generating userable model...');

        $modelStub = file_get_contents(__DIR__ . '/../Models/user_type_model.stub');

        $modelTargetPath = app_path($name . '.php');
        
        if (file_exists($modelTargetPath)) {
            $this->error('Model file already exist');
            return;
        }

        file_put_contents($modelTargetPath, strtr($modelStub, ['{{model}}' => $name]));


        $this->info('Generating userable table migration...');

        $migrationStub = file_get_contents(__DIR__ . '/../../database/migrations/user_type_migration.stub');


        $migrationClassName = Str::plural($name);
        $tableName = Str::snake($migrationClassName);

        $migrationTargetPath = database_path('migrations/' . date('Y_m_d_his', time()) . '_create_' . $tableName . '_table.php');
        file_put_contents($migrationTargetPath, strtr($migrationStub, [
            '{{migrationClassName}}' => $migrationClassName,
            '{{table}}' => $tableName,
        ]));
        
        $this->info('Userable generated...');
    }
}
