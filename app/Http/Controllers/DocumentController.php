<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDocument;
use App\Jobs\QRCodeStoreJob;
use App\Jobs\QRImageScanJob;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Local directory and file creation
        \Storage::disk('public')->makeDirectory($document->getKey());
        // Move file to Storage Folder
        \Storage::disk('public')->put($document->getKey() . '/' . $document->filename, \File::get($file));

        // Validate if document exists
        if (\Storage::disk('public')->exists($document->getKey() . '/' . $document->filename)) {

            // JOB process PDF to generate images peer page
            ProcessDocument::dispatch($document->getKey(), $document->filename);

            // Iterate Document's image folder to iterate each image and generate a txt file result.txt
            QRImageScanJob::dispatch($document->getKey(), $document->filename)->delay(now()->addSeconds(30));

            // Read result.txt for Document and store in database
            QRCodeStoreJob::dispatch($document->getKey())->delay(now()->addSeconds(60));
        }

        return response()->json(['success' => $fileName]);
    }
}
