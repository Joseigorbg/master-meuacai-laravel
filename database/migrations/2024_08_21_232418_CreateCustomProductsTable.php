<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ponto_id_fk')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 255);
            $table->decimal('price', 8, 2);
            $table->integer('quantity', false, true)->length(10);
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('ponto_id_fk')->references('id')->on('points')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

