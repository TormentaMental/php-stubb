<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardStackTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_stack', function (Blueprint $table) {

            $table->integer('card_id')->unsigned()->nullable()->index();
            $table->foreign('card_id')->references('id')
                ->on('cards')->onDelete('cascade');

            $table->integer('stack_id')->unsigned()->nullable()->index();
            $table->foreign('stack_id')->references('id')
                ->on('stacks')->onDelete('cascade');
            
            $table->primary(['card_id', 'stack_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_stack');
    }
}
