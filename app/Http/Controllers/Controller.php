<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\ApiClient\ApiConnector;
use Illuminate\Http\Client\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
