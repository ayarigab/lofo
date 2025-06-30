<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AutoTranslateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:auto
                            {--config= : Path to custom config file}
                            {--import : Import mode (requires CSV path)}
                            {--csv= : Path to CSV file/directory for import}
                            {--format=php : Output format (php or json)}
                            {--filename=translations : Base filename for output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically translate language files using Python translation service';

    /**
     * Path to Python translator script
     */
    protected $pythonScriptPath;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->pythonScriptPath = base_path('translator.py');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('import')) {
            return $this->handleImport();
        }

        return $this->handleTranslate();
    }

    /**
     * Handle translation mode
     */
    protected function handleTranslate()
    {
        $configPath = $this->option('config') ?? $this->getDefaultConfigPath();

        if (!File::exists($configPath)) {
            $this->error("Config file not found at: {$configPath}");
            return 1;
        }

        $this->info("Starting translation using config: {$configPath}");

        $process = new Process([
            'python3',
            $this->pythonScriptPath,
            'translate',
            $configPath
        ]);

        $process->setTimeout(3600); // 1 hour timeout
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error("Translation failed:");
            $this->error($process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
        $this->info("Translation completed successfully!");

        return 0;
    }

    /**
     * Handle import mode
     */
    protected function handleImport()
    {
        $csvPath = $this->option('csv');
        $format = $this->option('format');
        $filename = $this->option('filename');

        if (!$csvPath) {
            $this->error("CSV path is required for import mode (use --csv option)");
            return 1;
        }

        $this->info("Starting import from CSV: {$csvPath}");

        $process = new Process([
            'python3',
            $this->pythonScriptPath,
            'import',
            $csvPath,
            '--format',
            $format,
            '--filename',
            $filename
        ]);

        $process->setTimeout(3600); // 1 hour timeout
        $process->run();

        if (!$process->isSuccessful()) {
            $this->error("Import failed:");
            $this->error($process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
        $this->info("Import completed successfully!");

        return 0;
    }

    /**
     * Get default config file path
     */
    protected function getDefaultConfigPath()
    {
        return base_path('config/translations.json');
    }

    /**
     * Create default config file if it doesn't exist
     */
    protected function createDefaultConfig()
    {
        $defaultConfig = [
            "source_language" => "en",
            "target_languages" => ["es", "fr", "de"],
            "file_format" => "php",
            "filename" => "translations",
            "export_csv" => true,
            "csv_single_file" => true,
            "translation_api" => "google",
            "translations" => [
                "welcome" => "Welcome",
                "goodbye" => "Goodbye",
                "hello" => "Hello"
            ]
        ];

        $configPath = $this->getDefaultConfigPath();

        if (!File::exists($configPath)) {
            File::put($configPath, json_encode($defaultConfig, JSON_PRETTY_PRINT));
            $this->info("Created default config file at: {$configPath}");
        }

        return $configPath;
    }
}

// php artisan translate:auto --config=path/to/custom_config.json
// php artisan translate:auto --import --csv=path/to/translations.csv
// php artisan translate:auto --import --csv=path/to/translations --format=json --filename=custom_name
