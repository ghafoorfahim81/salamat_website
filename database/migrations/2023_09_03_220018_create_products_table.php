<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->double('stock_quantity')->nullable();
            $table->uuid('category_id')->nullable();
            $table->uuid('sub_category_id')->nullable();
            $table->uuid('brand_id')->nullable();
            $table->boolean('featured')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery_image')->nullable();
            $table->string('slug')->nullable();
            $table->string('weight')->nullable();
            $table->string('sizes')->nullable();
            $table->string('colors')->nullable();
            $table->string('unit')->nullable();
            $table->string('dimensions')->nullable();
            $table->text('tags')->nullable();
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
};
