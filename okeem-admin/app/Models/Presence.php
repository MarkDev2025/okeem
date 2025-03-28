<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $fillable = ['enfant_id', 'jour', 'heure_debut', 'heure_fin'];

    protected $casts = [
        'jour' => 'date:Y-m-d',  // Cast au bon format
        'heure_debut' => 'string',
        'heure_fin' => 'string',
    ];

    public function enfant()
    {
        return $this->belongsTo(Enfant::class);
    }
}
