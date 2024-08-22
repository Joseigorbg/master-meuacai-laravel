<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('point_id_fk'); // Chave estrangeira para Point
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('point_id_fk')->references('id')->on('points')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
