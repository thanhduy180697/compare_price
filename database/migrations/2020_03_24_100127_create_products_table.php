<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\softDeletes;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('product_name');
            $table->string('product_link',1000);
            $table->string('link_image',1000);
            $table->string('average_rating')->nullable();
            $table->string('display');
            $table->string('operating_system')->nullable();
            $table->string('front_camera')->nullable();
            $table->string('rear_camera')->nullable();
            $table->string('battery');
            $table->string('ram')->nullable();
            $table->string('cpu')->nullable();
            $table->string('brand')->nullable();
            $table->string('storage')->nullable();
            $table->integer('provider_id')->unsigned();
            $table->timestamps();
            $table->unique(['product_name', 'provider_id']);
            $table->foreign('provider_id')->references('id')->on('providers');
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
