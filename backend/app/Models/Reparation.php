<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reparation extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id',
        'date',
        'duree_main_oeuvre',
        'objet_reparation',
    ];

    /**
     * Une réparation appartient à un véhicule.
     */
    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Une réparation peut être réalisée par plusieurs techniciens (pivot).
     */
    public function techniciens(): BelongsToMany
    {
        return $this->belongsToMany(Technicien::class);
    }
}