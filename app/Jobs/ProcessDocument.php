<?php

namespace App\Jobs;

use App\Models\Document;
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
        info(__METHOD__);
        try {
            $document = Document::find($this->id);

            // State Machine
            $document->initWorkflow($document->user);
            if (!$document->workflow('can', ['document-processing'])) {
                throw new \Exception('Document change state not allowed for ('. $document->id .')');
            }

            // Parameters to generate images on STORAGE repository
            $directory = \Storage::disk('public')->path($this->id . '/');
            $file_path = (\Storage::disk('public')->path($this->id . '/' . $this->filename));

            // Run console command to split PDF file into images
            $process = new Process(['pdftocairo', $file_path, '-png', $directory . $this->id]);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            // Change state ON-PROCESSING
            $document->workflow('apply', ['document-processing']);
            $document->save();

        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
