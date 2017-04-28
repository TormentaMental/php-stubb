<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_user', function(Blueprint $table) {

            $table->integer('card_id')->unsigned()->nullable()->index();
            $table->foreign('card_id')->references('id')
                ->on('cards')->onDelete('cascade');
        
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            
            $table->primary(['card_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_user');
    }
}
