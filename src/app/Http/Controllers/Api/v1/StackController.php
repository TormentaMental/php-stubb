<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogHelper;
use App\Stack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use \App\Http\Controllers\Api\ApiBaseController;
use function response;

class StackController extends ApiBaseController
{
    use LogHelper;
    
    protected $repository;

    function __construct(Model $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * Get a single Stack
     * 
     * Lightweight version will not return cards info apart from the id
     * 
     * @param Request $request
     * @param int $id
     * @return json
     */
    public function show(Request $request, int $id)
    {
        $data = [];
        
        $this->authorize('ownership', $this->repository->findOrFail($id));
        
        try {

            $lightweight = filter_input(INPUT_GET, 'lightweight', FILTER_VALIDATE_BOOLEAN);

            if ($lightweight) {

                // retrieving lightweight data from DB
                $data = $this->repository->lightweight()->findOrFail($id);

                $cards = $data->cards->pluck('id')->all();
           
                // replacing object data with grouped lightweight data
                $data = $data->toArray();
            } else {

                $data = $this->repository->with('cards')->findOrFail($id)->toArray();
            }

        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => 'Not found' ], 404);
        } catch (\Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error retrieving the record' ], 500);
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {

            // validation
            $this->validate($request, [
                'name' => 'bail|required|max:255'
            ]);

            // new record                
            $stack = new Stack;            
            $stack->name = $request->input('name');
            $stack->description = $request->input('description');
            $stack->enabled = true;

            $stack->save();
            
            // assign to current user
            $user_id = $this->authenticatedUser()->id;
            $stack->users()->attach( $user_id );

        } catch (ValidationException $exc) {
            Log::error('Invalid data: ' . json_decode($request->getContent(), true));
            return response()->json([ 'message' => 'There was a validation error' ], 400);
        } catch (\Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error creating the record' ], 500);
        }

        return response()->json([
            'created'=>true,
            'id'=>$stack->id
            ], 201);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $this->authorize('ownership', $this->repository->findOrFail($id));
        
        try {

            // validation
            $this->validate($request, [
                'name' => 'bail|required|max:255'
            ]);

            // get existing record                
            $stack = $this->repository->find($id);  
            $stack->name = $request->input('name');
            $stack->description = $request->input('description');
            $stack->enabled = true;

            $stack->save();

        } catch (ValidationException $exc) {
            Log::error('Invalid data: ' . json_decode($request->getContent(), true));
            return response()->json([ 'message' => 'There was a validation error' ], 400);
        } catch (\Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error storing the record' ], 500);
        }

        return response("", 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        $this->authorize('ownership', $this->repository->findOrFail($id));
        
        try {

           $this->repository->destroy($id);
        } catch (\Exception $exc) {
            $this->logException($exc);
            return response()->json([ 'message' => 'There was an error deleting the record' ], 500);
        }

        return response("", 204);
    }
}
