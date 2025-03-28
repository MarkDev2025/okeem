<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Enfant extends Model
{
    use HasFactory;
    protected $fillable = ['prenom', 'nom', 'slug', 'date_naissance', 'etablissement_id', 'avatar'];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function tuteurs()
    {
        return $this->belongsToMany(Tuteur::class, 'enfant_tuteur');
    }

    public function transmissions()
    {
        return $this->hasMany(Transmission::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($enfant) {
            $enfant->slug = Str::slug($enfant->prenom . ' ' . $enfant->nom, '-');
        });
        static::updating(function ($enfant) {
            if ($enfant->isDirty('nom')) { // Mise à jour uniquement si le nom change
                $enfant->slug = Str::slug($enfant->prenom . ' ' . $enfant->nom, '-');
            }
        });
    }
}
