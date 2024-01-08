<?php
// app/Console/Commands/MakeServiceFiles.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeServiceFiles extends Command
{
    protected $signature = 'make:service-files {name}';
    protected $description = 'Create files for a new service';

    public function handle(Filesystem $filesystem)
    {
        $name = $this->argument('name');
        $interfaceName = Str::studly($name);
        $implementationName = Str::studly($name) . 'Implementation';

        $interfacePath = app_path("Services/{$interfaceName}.php");
        $implementationPath = app_path("Services/Implements/{$implementationName}.php");

        if ($filesystem->exists($interfacePath) || $filesystem->exists($implementationPath)) {
            $this->error('Service files already exist!');
            return;
        }

        $filesystem->put($interfacePath, $this->interfaceStub($interfaceName));
        $filesystem->put($implementationPath, $this->implementationStub($implementationName, $interfaceName));

        $this->info('Service files created successfully.');
    }

    protected function interfaceStub($interfaceName)
    {
        return <<<INTERFACE
<?php

namespace App\Services;

interface {$interfaceName}
{
    // Define your interface methods here
}
INTERFACE;
    }

    protected function implementationStub($implementationName, $interfaceName)
    {
        return <<<IMPLEMENTATION
<?php

namespace App\Services\Implements;

use App\Services\\{$interfaceName};

class {$implementationName} implements {$interfaceName}
{
    // Implement your methods here
}
IMPLEMENTATION;
    }
}
