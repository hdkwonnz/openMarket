<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstoptionSecondoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firstoption_secondoption', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firstoption_id');
            $table->unsignedBigInteger('secondoption_id');
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
        Schema::dropIfExists('firstoption_secondoption');
    }
}
