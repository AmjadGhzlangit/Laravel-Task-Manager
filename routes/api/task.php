<?php

use App\Http\API\V1\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);
