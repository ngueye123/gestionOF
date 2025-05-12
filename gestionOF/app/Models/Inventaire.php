<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;

    protected $table = 'inventaire';
    protected $primaryKey = 'idInventaire';
    public $timestamps = false;

    protected $fillable = [
        'idPersonnel',
        'status',
        'dateSoumission',
        'dateValidation',
    ];
    protected $attributes = [
        'status' => 'En attente',
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'idPersonnel');
    }

    public function details()
    {
        return $this->hasMany(InventaireDetail::class, 'idInventaire');
    }
}
