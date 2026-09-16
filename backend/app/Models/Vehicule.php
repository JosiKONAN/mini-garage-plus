<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'immatriculation',
        'marque',
        'modele',
        'couleur',
        'annee',
        'kilometrage',
        'carrosserie',
        'energie',
        'boite',
        'image',
    ];

    /**
     * Un véhicule possède plusieurs réparations.
     */
    public function reparations(): HasMany
    {
        return $this->hasMany(Reparation::class);
    }
}