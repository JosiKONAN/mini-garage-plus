<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Technicien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'specialite',
    ];

    /**
     * Un technicien peut participer à plusieurs réparations (pivot).
     */
    public function reparations(): BelongsToMany
    {
        return $this->belongsToMany(Reparation::class);
    }
}