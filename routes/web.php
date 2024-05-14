<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\XeroController;

Route::get('/manage/xero', [XeroController::class, 'index'])->name('xero.auth.success');

// Route::get('/put-existing', function() {
//     $filename = 'QU1045.pdf';
//     $filePath = public_path($filename);

//     Storage::disk('google')->put($filename, File::get($filePath));

//     return 'File was saved to Google Drive';
// });

// Route::get('/upload-monday', function() {
//     // $filename = 'QU1045.pdf';
//     // $filePath = public_path($filename);
//     // $fileData = File::get($filePath);

//     // // $query = "add_file_to_update (update_id: 6591819053, file: {$fileData} ) {
//     // //     id
//     // // }";

//     $monday = Monday::getBoards();

//     dump($monday);

//     // return 'File was saved to Google Drive';
// });