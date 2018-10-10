<?php
/**
 * Created by PhpStorm.
 * User: liemleitvn
 * Date: 10/10/2018
 * Time: 11:30
 */

namespace App\Services;

use App\Helpers\ApiHelper;


class GetUser
{
    private $apiHelper;

    public function __construct(ApiHelper $apiHelper)
    {
        $this->apiHelper = $apiHelper;
    }

    public function execute() {
        $result = $this->apiHelper->getJson('user-info');

        return $result;
    }
}
