<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class AutoTranslateCommand extends Command
{
    protected $signature = 'translate:auto
                            {source_file : Path to source translation file}
                            {--source=en : Source language code}
                            {--targets= : Comma-separated target language codes}
                            {--format=json : Output format (json or php)}
                            {--output= : Custom output filename}';

    protected $description = 'Automatically translate files using the Python translator';

    public function handle()
    {
        $sourceFile = $this->argument('source_file');
        $sourceLang = $this->option('source');
        $targets = $this->option('targets');
        $format = $this->option('format');
        $output = $this->option('output');
        // Build the Python command
        $pythonScript = base_path('translator.py');
        $command = [
            'python3',
            $pythonScript,
            $sourceFile,
            '--source=' . $sourceLang,
            '--targets=' . $targets,
            '--format=' . $format,
        ];

        if ($output) {
            $command[] = '--output=' . $output;
        }

        $process = new Process($command);
        $process->setTimeout(300);

        try {
            $process->mustRun(function ($type, $buffer) {
                $this->output->write($buffer);
            });
            $this->info('Translation completed successfully!');
            return 0;
        } catch (ProcessFailedException $exception) {
            $this->error('Translation failed: ' . $exception->getMessage());
            return 1;
        }
    }
}
