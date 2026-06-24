<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('administrador', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->string('nome');
        $table->string('email');
        $table->string('telefone', 11);
        $table->string('cpf', 11);
        $table->string('usuario');
        $table->string('senha');
        $table->string('status', 50);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrador');
    }
};
