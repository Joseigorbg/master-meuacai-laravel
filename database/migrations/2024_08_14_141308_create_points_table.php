<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(); // Foreign key to users table
            $table->unsignedBigInteger('ponto_id_fk')->nullable();
            $table->string('name', 40);
            $table->string('tel_contato', 20)->nullable(); // Novo campo para telefone de contato
            $table->unsignedBigInteger('complementos_A')->nullable();
            $table->unsignedBigInteger('endereco_A')->nullable();
            $table->unsignedBigInteger('id_products')->nullable();
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude column
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude column
            $table->unsignedBigInteger('likes_count')->default(0); // Novo campo para contagem de likes
            $table->boolean('is_highlighted')->default(0); // Novo campo para destacar o ponto
            $table->timestamps();

            // Indexes and Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
