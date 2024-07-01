<?php

namespace App\Http\API\V1\Controllers;

use App\Traits\ApiResponse;
use App\Traits\FileUpload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponse , AuthorizesRequests, DispatchesJobs, FileUpload, ValidatesRequests;
}
