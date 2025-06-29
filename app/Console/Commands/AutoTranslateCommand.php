<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AutoTranslateCommand extends Command
{
    protected $signature = 'translate:auto
                            {source_file : Path to source JSON file containing translations}
                            {--source=en : Source language code (default: en)}
                            {--targets= : Comma-separated target language codes (e.g. es,fr,ar)}
                            {--api=google : Translation API: google|mymemory|microsoft}
                            {--email= : Email for MyMemory API}
                            {--azure-key= : Azure key for Microsoft Translator}
                            {--output-format=json : Output format: json or php}
                            {--filename=translations : Base filename for output files}
                            {--csv : Export translations to CSV}';

    protected $description = 'Automatically generate translations using the Python translator';

    public function handle()
    {
        // Validate required arguments
        $sourceFile = $this->argument('source_file');
        if (!file_exists($sourceFile)) {
            $this->error("Source file not found: {$sourceFile}");
            return 1;
        }

        // Build config for Python script
        $config = [
            'translations' => json_decode(file_get_contents($sourceFile), true),
            'source_language' => $this->option('source'),
            'target_languages' => explode(',', $this->option('targets') ?: 'es,fr'),
            'translation_api' => $this->option('api'),
            'file_format' => $this->option('output-format'),
            'filename' => $this->option('filename'),
            'export_csv' => (bool)$this->option('csv'),
            'csv_single_file' => false, // Optional extra feature you can add later
        ];

        // Add optional credentials
        if ($this->hasOption('email') && $this->option('email')) {
            $config['api_key_username'] = $this->option('email');
        }

        if ($this->hasOption('azure-key') && $this->option('azure-key')) {
            $config['api_key_username'] = $this->option('azure-key');
        }

        // Write config to temporary file
        $configPath = base_path('.translator_config.json');
        file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Run Python script
        $pythonScript = base_path('translator.py');
        $command = ['python3', $pythonScript, 'translate', $configPath];

        $process = new Process($command);
        $process->setTimeout(600); // Increase timeout for large translations

        try {
            $process->mustRun(function ($type, $buffer) {
                $this->output->write($buffer);
            });

            $this->info('✅ Translation completed successfully!');
            return 0;
        } catch (ProcessFailedException $exception) {
            $this->error('❌ Translation failed: ' . $exception->getMessage());
            return 1;
        } finally {
            @unlink($configPath); // Clean up temp config
        }
    }
}
