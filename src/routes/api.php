<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * APIs
 */
Route::group([
    'namespace' => 'Api',
    'middleware' => ['auth:api'],
    ], function () {

    Route::get('/', function() {

        return [
            'greetings' => 'Welcome to Stubb API',
            'api-version' => Config::get('app.api_version')
        ];
    });

    /**
     * API v1
     */
    Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function($app) {
        
        Route::pattern('id', '[0-9]+');
        
        // Basic CRUD
        Route::resource('cards', 'CardController', ['except' => ['create', 'edit']]);
        Route::resource('stacks', 'StackController', ['except' => ['index', 'create', 'edit']]);
        Route::resource('tags', 'TagController', ['only' => ['index', 'show', 'destroy']]);
                       
        /**
         * User stacks
         * @overrides resource method
         */
        Route::get('stacks', 'StackUserController@index');
        
        /**
         * ALl cards w/tags
         */
        Route::get('cards/tags/all', "CardTagController@index");
        
        /**
         * Single card w/tags
         */
        Route::get('cards/{id}/tags', "CardTagController@showTags");
        
        /**
         * Single tag cards
         */
        Route::get('tags/{id}/cards', 'CardTagController@showCards');
        
        /**
         * Create tag and assign to card
         */
        Route::post('cards/{card_id}/tags', 'CardTagController@store');

        /**
         * Stack cards
         */
        Route::get('stacks/{stack_id}/cards', "CardStackController@showCards");
        
        /**
         * Cards stacks
         */
        Route::get('cards/{card_id}/stacks', "CardStackController@showStacks");
        
        /**
         * Assign card to stack
         */
        Route::put('cards/{card_id}/stacks/{stack_id}', "CardStackController@update");
        Route::put('stacks/{stack_id}/cards/{card_id}', "CardStackController@update");
    });
    
    // prevent looping
    Route::get(Config::get('app.api_version'). '/' . Config::get('app.api_version'), function () {
        return redirect()->to('/api');
    });

    // redirect to current api version
    Route::get('{any?}', function ($any = null) {
        $current_api_version = Config::get('app.api_version');
        return redirect()->to("/api/{$current_api_version}/{$any}");
    })->where('any', '.*');
});


