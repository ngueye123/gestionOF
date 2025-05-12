<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireDetail extends Model
{
    use HasFactory;

    protected $table = 'inventaire_details';
    protected $primaryKey = 'idDetail';
    public $timestamps = false;

    protected $fillable = [
        'idInventaire',
        'ancienne_quantite',
        'nouvelle_quantite',
        'idProduit',
    ];

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'idInventaire');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'idProduit');
    }
}
