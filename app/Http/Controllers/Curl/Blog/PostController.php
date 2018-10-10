<?php

namespace App\Http\Controllers\Curl\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiHelper;
use App\Services\InsertPost;
use App\Services\UpdatePost;

class PostController extends Controller
{
    private $apiHelper;
    private $inserPost;
    private $updatePost;


    public function __construct(ApiHelper $apiHelper, InsertPost $insertPost, UpdatePost $updatePost)
    {
        $this->apiHelper = $apiHelper;
        $this->inserPost = $insertPost;
        $this->updatePost = $updatePost;
    }

    public function index () {

        $result = $this->apiHelper->getJson('posts');
        if(empty($result[0]['id']) || empty($result[0]['title']) || empty($result[0]['content'])) {
            return view('blog.error')->with(['errors'=>$result]);
        }
        return view('blog.show')->with(['result'=>$result]);

    }


    public function create() {

        $result = $this->apiHelper->getJson('categories');


        if(empty($result[0]['id']) || empty($result[0]['name'])) {

            return view('blog.error')->with(['errors'=>$result]);
        }

        return view ('blog.create')->with(['category'=>$result]);
    }


    public function store(Request $request) {
        $result = $this->inserPost->execute($request);
    }


    public function edit($id) {
        $category = $this->apiHelper->getJson('categories');

        if(empty($category[0]['id']) || empty($category[0]['name'])) {

            return view('blog.error')->with(['errors'=>$category]);
        }

        $post = $this->apiHelper->getJson('posts/'.$id);

        return view ('blog.edit')->with(['category'=>$category, 'id'=>$id, 'post'=>$post[0]]);
    }


    public function update(Request $request, $id) {
        $result = $this->updatePost->execute($request,$id);
    }

    public function destroy($id) {
        $result = $this->apiHelper->deleteJson('posts/'.$id);

        $result = json_decode($result, true);

        if(!empty($result)) {
            return view ('blog.error')->with(['errors'=>$result]);
        }

        return response()->redirectToRoute('blog.posts.index');

    }

}
