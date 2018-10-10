<?php

namespace App\Http\Controllers\Curl\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;

class CategoryController extends Controller
{
    private $apiHelper;

    public function __construct(ApiHelper $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    public function index () {

    }
}
