<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    /**
     *
     * @var \App\User 
     */
    private $user;

    public function __construct()
    {
        // get user by api token
        $this->user = auth('api')->user();
    }

    protected function authenticatedUser()
    {
        return $this->user;
    }
}
