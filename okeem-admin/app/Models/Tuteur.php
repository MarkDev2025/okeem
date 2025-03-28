<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tuteur extends Model
{
    use HasFactory;
    protected $fillable = ['prenom', 'nom', 'slug', 'email', 'telephone'];

    public function enfants()
    {
        return $this->belongsToMany(Enfant::class, 'enfant_tuteur');
    }

    public function etablissements()
    {
        return $this->belongsToMany(Etablissement::class, 'tuteur_etablissement');
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($tuteur) {
            $tuteur->slug = Str::slug($tuteur->prenom . ' ' . $tuteur->nom, '-');
        });
        static::updating(function ($tuteur) {
            if ($tuteur->isDirty('nom')) { // Mise à jour uniquement si le nom change
                $tuteur->slug = Str::slug($tuteur->prenom . ' ' . $tuteur->nom, '-');
            }
        });
    }
}
