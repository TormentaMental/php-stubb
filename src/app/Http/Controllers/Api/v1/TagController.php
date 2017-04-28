<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Tag;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use function response;

class TagController extends ApiBaseController
{

    protected $repository;

    function __construct(Tag $repository)
    {
        parent::__construct();
        $this->repository = $repository; // TODO: retrieve real repository
    }
    
    /**
     * Display a listing of the tags.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        
        try {

            $data = $this->repository->all();
        } catch (Exception $exc) {
            Log::error(get_class() . ' ' . $exc->getMessage());
            return response()->json([ 'message' => 'There was an error retrieving the records' ], 500);
        }

        return $data;
    }

    /**
     * Get a single Tag
     * 
     * Lightweight version will not return cards info apart from the id
     * 
     * @param Request $request
     * @param int $id
     * @return json
     */
    public function show(Request $request, int $id)
    {
        $this->authorize('ownership', $this->repository->findOrFail($id));
        
        $data = [];
        
        try {

            $data = $this->repository->with('cards')->findOrFail($id)->toArray();
           
        } catch (ModelNotFoundException $e) {
            return response()->json([ 'message' => 'Not found' ], 404);
        } catch (Exception $exc) {
            Log::error(get_class() . ' ' . $exc->getMessage());
            return response()->json([ 'message' => 'There was an error retrieving the record' ], 500);
        }

        return $data;
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
        } catch (Exception $exc) {
            Log::error(get_class() . ' ' . $exc->getMessage());
            return response()->json([ 'message' => 'There was an error deleting the record' ], 500);
        }

        return response("", 204);
    }
}
