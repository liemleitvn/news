<?php

namespace App\Http\Controllers\Curl\Blog;


use App\Services\LoginBlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class LoginController extends Controller
{

    private $loginBlog;

    public function __construct(LoginBlog $loginBlog)
    {
        $this->loginBlog = $loginBlog;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('blog.login');
    }


    /**
     * @param Request $request
     * Login to blog.local
     * Return token api
     */
    public function login(Request $request) {

        //execute login blog from class BlogService/Login.php
        $result = $this->loginBlog->login($request);

        return view('blog.home')->with(['result'=>$result]);

    }
}
