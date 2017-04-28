<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Traits\LogHelper;
use App\Stack;
use Exception;
use Illuminate\Http\Response;
use function response;

class StackUserController extends ApiBaseController
{
    use LogHelper;
    
    /**
     * Display a listing of the stacks.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        
        try {
            
            $data = auth('api')->user()
                ->stacks()->select(['id', 'name'])->withUsers()
                ->get();
            
        } catch (Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error retrieving the records' ], 500);
        }

        return $data;
    }
}
