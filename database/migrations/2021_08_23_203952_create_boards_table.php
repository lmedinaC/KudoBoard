<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description');
            $table->date('start_date')->nullable();  
            $table->date('end_date')->nullable();  
            $table->integer('num_max_guest')->default('10');

            //* foreign key
            $table->unsignedInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('workers');
            
            $table->softDeletes();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
