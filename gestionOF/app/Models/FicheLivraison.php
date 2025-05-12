<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FicheLivraison extends Model
{
    protected $table = 'fichelivraison';
    protected $primaryKey = 'idLivraison';
    public $timestamps = false;

    protected $fillable = [
        'idOF', 'idPersonnel','dateLivraison'
    ];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'idPersonnel');
    }

    public function ordreFabrication()
    {
        return $this->belongsTo(OrdreFabrication::class, 'idOF');
    }
}
