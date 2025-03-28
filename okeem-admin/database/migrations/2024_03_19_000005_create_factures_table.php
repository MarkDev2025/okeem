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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuteur_id')->constrained('tuteurs');
            $table->foreignId('etablissement_id')->constrained('etablissements');
            $table->decimal('montant', 8, 2);
            $table->enum('statut', ['payee', 'envoyee', 'en_retard']);
            $table->string('pdf')->nullable(); // Champ pour un fichier PDF facultatif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
