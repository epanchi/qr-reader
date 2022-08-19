<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessDocument;
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

        \Storage::disk('public')->makeDirectory(
            $document->getKey()
        );
        // Move file to Storage Folder
        \Storage::disk('public')->put($document->getKey() . '/' . $document->filename, \File::get($file));

        // Run QUEUE

        if (\Storage::disk('public')->exists($document->getKey() . '/' . $document->filename)) {

            ProcessDocument::dispatch($document->getKey(), $document->filename)->delay(now()->addSecond(20));;


            //    echo ;
        }


        return response()->json(['success' => $fileName]);
    }
}
