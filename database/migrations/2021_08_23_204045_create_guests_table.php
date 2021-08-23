<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');

            //* foreign key
            $table->unsignedInteger('guest_id');
            $table->foreign('guest_id')->references('id')->on('workers')->onDelete('cascade');
            $table->unsignedInteger('board_id');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade');

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
        Schema::dropIfExists('guests');
    }
}
