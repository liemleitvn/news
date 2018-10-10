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
        $request->flashOnly('title','content');
        $result = $this->inserPost->execute($request);

        if(!empty($result['errors'])) {

            $errors = $result;

            return redirect()->route('blog.posts.create')->withErrors($errors);
        }
        return redirect()->route('blog.posts.index')->with(['success'=>'Insert successful']);
    }


    public function edit($id) {
        $category = $this->apiHelper->getJson('categories');

        if(empty($category[0]['id']) || empty($category[0]['name'])) {

            return view('blog.posts.edit')->withErrors($category);
        }

        $post = $this->apiHelper->getJson('posts/'.$id);

        return view ('blog.edit')->with(['category'=>$category, 'id'=>$id, 'post'=>$post[0]]);
    }


    public function update(Request $request, $id) {
        $request->flashOnly('title','content');
        $result = $this->updatePost->execute($request,$id);



        if(!empty($result['errors'])) {
            $errors = $result;

            return redirect()->route('blog.posts.edit',['id'=>$id])->withErrors($errors);
        }
        return redirect()->route('blog.posts.index')->with(['success'=>'Update successful']);
    }

    public function destroy($id) {
        $result = $this->apiHelper->deleteJson('posts/'.$id);

        $result = json_decode($result, true);

        if(!empty($result)) {
            return view ('blog.error')->with(['errors'=>$result]);
        }

        return response()->redirectToRoute('blog.posts.index')->with(['success'=>'Delete successful']);

    }

}
