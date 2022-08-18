<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;



class DocumentController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function fileupload(Request $request)
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        // Create record with fillable elements
        $document = Document::create(['user_id' => Auth::user()->id, 'original_filename' => $file->getClientOriginalName()]);

        // After generate record, filename was renamed to ID.pdf
        $document->filename = 'document' . '.' . $file->getClientOriginalExtension();
        $document->update();

        \Storage::disk('public')->makeDirectory(
            $document->getKey()
        );
        // Move file to Storage Folder
        \Storage::disk('public')->put($document->getKey() . '/' . $document->filename, \File::get($file));

        // Run QUEUE
        $directory = \Storage::disk('public')->path($document->getKey() . '/');
        info($directory);

        $file_path = (\Storage::disk('public')->path($document->getKey() . '/' . $document->filename));
        if (\Storage::disk('public')->exists($document->getKey() . '/' . $document->filename)) {
            info('path-exist');
            info($file_path);
            $process = new Process(['pdftocairo', $file_path, '-png', $directory]);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            info($process->getOutput());
            //    echo ;
        }


        return response()->json(['success' => $fileName]);
    }
}
