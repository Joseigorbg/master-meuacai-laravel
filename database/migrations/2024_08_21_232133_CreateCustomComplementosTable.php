<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateCustomComplementosTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('complementos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('point_id_fk')->nullable();
            $table->text('days_hours')->nullable();
            $table->json('videos')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('images')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('point_id_fk')->references('id')->on('points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementos');
    }
};

