<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->increments('id');

            //* foreign key
            $table->unsignedInteger('recipient_id');
            $table->foreign('recipient_id')->references('id')->on('workers')->onDelete('cascade');
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
        Schema::dropIfExists('recipients');
    }
}
