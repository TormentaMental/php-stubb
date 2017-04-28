<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStackUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stack_user', function(Blueprint $table) {

            $table->integer('stack_id')->unsigned()->nullable()->index();
            $table->foreign('stack_id')->references('id')
                ->on('stacks')->onDelete('cascade');
        
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
            
            $table->primary(['stack_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stack_user');
    }
}
