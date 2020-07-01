<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('categorya_id');
            $table->unsignedBigInteger('categoryb_id');
            $table->unsignedBigInteger('categoryc_id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->decimal('price', 10,2);
            $table->decimal('sale_price', 10,2);
            // $table->decimal('sale_rate',5,2);
            $table->string('unit_measurement');
            $table->float('stock')->nullable();
            $table->string('image_path');
            $table->text('photo_paths')->nullable();
            $table->string('details_path')->nullable();
            $table->integer('number_option')->nullable();
            $table->string('sku')->nullable();
            $table->string('country_origin')->nullable();
            $table->string('brand')->nullable();
            $table->string('weight')->nullable();
            $table->text('ingredients')->nullable();////
            $table->string('nutrition_facts')->nullable();
            $table->string('description')->nullable();
            $table->string('info')->nullable();
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
        Schema::dropIfExists('products');
    }
}
