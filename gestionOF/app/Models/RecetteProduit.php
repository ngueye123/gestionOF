<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetteProduit extends Model
{
    protected $table = 'recette_produit';
    public $timestamps = false;

    protected $fillable = ['idRecette', 'idProduit', 'quantite'];
}
