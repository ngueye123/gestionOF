<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $table = 'produit';
    protected $primaryKey = 'idProduit';
    public $timestamps = false;

    protected $fillable = ['nom', 'quantite'];

    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'recette_produit', 'idProduit', 'idRecette')
            ->withPivot('quantite');
    }

    public function details()
    {
        return $this->hasMany(InventaireDetail::class, 'idInventaire');
    }
}
