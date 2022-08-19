<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $filename)
    {
        $this->id = $id;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $directory = \Storage::disk('public')->path($this->id . '/');
        info($directory);

        $file_path = (\Storage::disk('public')->path($this->id . '/' . $this->filename));

        info('path-exist');
        info($file_path);

        // Nunprocess
        // $process = new Process(['pdftocairo', $file_path, '-png', $directory . $this->id]);
        // $process->run();

        // // executes after the command finishes
        // if (!$process->isSuccessful()) {
        //     throw new ProcessFailedException($process);
        // }
        // info($process->getOutput());

        info('qr-generation');
        info(base_path() . '/qr.bash');
        info($directory);

        // Nunprocess
        $process = new Process(['sh', base_path() . '/qr.bash', $directory, $file_path, $this->id]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        info($process->getOutput());
    }
}
