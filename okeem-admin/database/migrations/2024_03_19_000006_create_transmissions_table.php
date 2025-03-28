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
        Schema::create('transmissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('okeemien_id')->constrained('okeemiens');
            $table->foreignId('enfant_id')->constrained('enfants');
            $table->foreignId('etablissement_id')->constrained('etablissements');
            $table->text('message');
            $table->string('fichier')->nullable(); // Peut contenir une image, un document ou une vidéo
            $table->date('jour');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmissions');
    }
};
