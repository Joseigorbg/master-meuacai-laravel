<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProviderAndProfilePictureToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider_id')->nullable()->after('password'); // Coluna para armazenar o ID do provedor
            $table->string('provider_name')->nullable()->after('provider_id'); // Coluna para armazenar o nome do provedor
            $table->string('profile_picture')->nullable()->after('name'); // Coluna para armazenar a foto de perfil
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('provider_id');
            $table->dropColumn('provider_name');
            $table->dropColumn('profile_picture');
        });
    }
}
