<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Action class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $segments = explode('/', $name);
        $className = array_pop($segments);
        $subPath = implode('/', $segments);

        $directory = app_path('Actions/' . $subPath);
        $path = $directory . "/{$className}.php";

        $namespace = 'App\\Actions' . ($subPath ? '\\' . str_replace('/', '\\', $subPath) : '');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $content = <<<PHP
<?php

namespace {$namespace};

class {$className}
{
    public function execute()
    {
        //
    }
}

PHP;

        file_put_contents($path, $content);
    }
}
