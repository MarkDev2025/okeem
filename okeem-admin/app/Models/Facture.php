<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = ['tuteur_id', 'montant', 'statut', 'pdf', 'etablissement_id'];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
}
