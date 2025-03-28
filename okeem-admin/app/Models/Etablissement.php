<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'slug', 'type', 'lieu', 'nom_responsable', 'nombre_okeemiens', 'avatar'];

    public function enfants()
    {
        return $this->hasMany(Enfant::class);
    }

    public function tuteurs()
    {
        return $this->belongsToMany(Tuteur::class, 'tuteur_etablissement');
    }

    public function okeemiens()
    {
        return $this->belongsToMany(Okeemien::class, 'okeemien_etablissement');
    }

    public function transmissions()
    {
        return $this->hasMany(Transmission::class);
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($etablissement) {
            $etablissement->slug = Str::slug($etablissement->nom, '-');
        });
        static::updating(function ($etablissement) {
            if ($etablissement->isDirty('nom')) { // Mise à jour uniquement si le nom change
                $etablissement->slug = Str::slug($etablissement->nom, '-');
            }
        });
    }
}
