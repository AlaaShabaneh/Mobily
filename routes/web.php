<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ModelController;

Route::get('/manage-brands-models', function () {
    return view('manage-brands-models');
});
