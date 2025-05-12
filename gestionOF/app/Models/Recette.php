<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $table = 'recette';
    protected $primaryKey = 'idRecette';
    public $timestamps = false;

    protected $fillable = ['nom',];

   
    public function ordresFabrication()
    {
        return $this->hasMany(OrdreFabrication::class, 'idRecette');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'recette_produit', 'idRecette', 'idProduit')
            ->withPivot('quantite');
    }
   
    
}
