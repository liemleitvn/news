<?php
/**
 * Created by PhpStorm.
 * User: liemleitvn
 * Date: 10/10/2018
 * Time: 15:18
 */

namespace App\Services;

use App\Helpers\ApiHelper;
use Validator;

class UpdatePost
{

    private $apiHelper;

    public function __construct(ApiHelper $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    public function execute($request, $id) {
        $validator = Validator::make($request->all(),[
            'title'=>'bail|required|max:100',
            'category'=>'bail|required|numeric',
            'content'=>'bail|required'
        ]);

        if($validator->fails()) {
            return view('blog.error')->with(['error'=>$validator->errors()->first()]);
        }

        $data = array();

        $data['title'] = $request->get('title');
        $data['content'] = $request->get('content');
        $data['category'] = $request->get('category');

        $result = $this->apiHelper->updateJson('posts/'.$id ,$data);

        dd($result);
    }
}
