<?php

namespace Core\Http\Controllers;

use Core\Traits\ApiResponse;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use ApiResponse;
}
