<?php

namespace App\Http\Controllers\Api\v1;

use App\Card;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Traits\LogHelper;
use App\Services\QueryService;
use App\Stack;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function response;

class CardStackController extends ApiBaseController
{
    use LogHelper;
    
    /**
     * Display the card with stacks.
     *
     * @param  int $id
     * @return Response
     */
    public function showStacks(int $card_id)
    {        
        $card = Card::findOrFail($card_id);
        $this->authorize('ownership', $card);
        
        $data = [];
       
        try {
         
            $data = Card::with('stacks')->findOrFail($card_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => 'Not found'], 404);
        } catch (Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error retrieving the record' ], 500);
        }

        return $data;
    }
    
    /**
     * Display the stack cards.
     *
     * @param  int $id
     * @return Response
     */
    public function showCards(Request $request, QueryService $query, int $stack_id)
    {        
        $data = [];
        
        try {
    
            $data = $query->searchByStack($stack_id);
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => 'Not found'], 404);
        } catch (Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error retrieving the record' ], 500);
        }

        return $data;
    }
    
    /**
     * Assign card to stack
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(int $card_id, int $stack_id)
    {
        $this->authorize('ownership', Stack::findOrFail($stack_id));
        
        try {
         
            // assign card to stack               
            $stack = Stack::findOrFail($stack_id)->cards()->attach($card_id); 
  
        } catch (Exception $exc) {
            
            $this->logException($exc);         
            return response()->json([ 'message' => 'There was an error storing the record' ], 500);
        } 
            
        return response("", 204);
    }
}
