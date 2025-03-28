<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;
    protected $fillable = ['okeemien_id', 'enfant_id', 'message', 'jour', 'heure_debut', 'heure_fin', 'fichier'];

    protected $casts = [
        'jour' => 'date:Y-m-d',  // Cast au bon format
        'heure_debut' => 'string',
        'heure_fin' => 'string',
    ];

    public function okeemien()
    {
        return $this->belongsTo(Okeemien::class);
    }

    public function enfant()
    {
        return $this->belongsTo(Enfant::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
}
