<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('description');

            //* foreign key
            $table->unsignedInteger('guest_id');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');

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
        Schema::dropIfExists('publications');
    }
}
