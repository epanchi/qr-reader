<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpParser\Comment\Doc;

class QRCodeStoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
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
            $file_path = (\Storage::disk('public')->path($this->id . '/result.txt'));

            $document = Document::find($this->id);

            // State Machine
            $document->initWorkflow($document->user);
            if (!$document->workflow('can', ['document-processed'])) {
                throw new \Exception('Document change state not allowed for ('. $document->id .')');
            }


            if (\Storage::disk('public')->exists($this->id . '/result.txt')) {
                $fhandle = fopen($file_path, 'r');
                $code = null;
                while ($row = fgetcsv($fhandle)) {

                    $code .= $row[0];
                }
                info($code);
                $document->workflow('apply', ['document-processed']);
                $document->save();
            }
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
