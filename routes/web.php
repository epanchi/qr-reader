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
