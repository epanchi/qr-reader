<?php

use App\Models\Document;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    $documents = Document::get();
    foreach ($documents as $d) {
        $d->initWorkFlow();
        if (!$d->workflow('can', ['processing'])) {
            throw new \Exception('Error');
        }

        $d->workflow('apply', ['processing']);
        $d->save();
    }
    dd('edd');
    $document = new Document(['userid' => 1, 'filename' => 'new']);
    // $document->initWorkFlow();

    //  $document->setFiniteState('submitted');

    if (!$document->workflow('can', ['receive'])) {
        throw new \Exception('Error');
    }


    $document->workflow('apply', ['receive']);
    $document->save();

    dd($document);

    return view('welcome');
});



Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::get('/dashboard', function () {
            $documents = Document::get();
            return view('dashboard', ['documents' => $documents]);
        });

        Route::get('/upload', function () {
            return view('upload');
        });

        Route::post('/fileupload/', 'App\Http\Controllers\DocumentController@fileupload')->name('fileupload');
    }
);



require __DIR__ . '/auth.php';
