<?php
/**
 * Created by PhpStorm.
 * User: liemleitvn
 * Date: 10/10/2018
 * Time: 10:47
 */

namespace App\Services;

use Validator;
use App\Helpers\ApiHelper;
use App\Services\GetUser;


class InsertPost
{
    private $apiHelper;
    private $getUser;

    public function __construct(ApiHelper $apiHelper, GetUser $getUser)
    {
        $this->apiHelper = $apiHelper;
        $this->getUser = $getUser;
    }

    public function execute($request) {

        $validator = Validator::make($request->all(),[
            'title'=>'bail|required|max:100',
            'category'=>'bail|required|numeric',
            'content'=>'bail|required'
        ]);

        //validate error
        if ($validator->fails()) {
            $errors = $validator->errors()->first();

            return view('blog.error')->with(['errors'=>$errors]);
        }

        $data = array();

        $data['title'] = $request->get('title');
        $data['content'] = $request->get('content');
        $data['category'] = $request->get('category');

        $result = $this->apiHelper->postJson('posts',$data);

        if ($result !== "") {
            return view('blog.error')->with(['errors'=>$result]);
        }

        return view('blog.show');
    }
}
