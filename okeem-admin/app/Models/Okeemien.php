<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Okeemien extends Model
{
    use HasFactory;
    protected $fillable = ['prenom', 'nom', 'slug', 'email', 'telephone'];

    public function etablissements()
    {
        return $this->belongsToMany(Etablissement::class, 'okeemien_etablissement');
    }

    public function transmissions()
    {
        return $this->hasMany(Transmission::class);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($okeemien) {
            $okeemien->slug = Str::slug($okeemien->prenom . ' ' . $okeemien->nom, '-');
        });
        static::updating(function ($okeemien) {
            if ($okeemien->isDirty('nom')) { // Mise à jour uniquement si le nom change
                $okeemien->slug = Str::slug($okeemien->prenom . ' ' . $okeemien->nom, '-');
            }
        });
    }
}
