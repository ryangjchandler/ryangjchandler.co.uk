<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Ryangjchandler\NovaStorageManager\Http\Controllers\FilesController;

Route::get('/files', FilesController::class)->name('storage-manager.files');
