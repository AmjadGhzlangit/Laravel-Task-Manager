<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    require __DIR__ . '/api/task.php';

    require __DIR__ . '/api/auth.php';

});
