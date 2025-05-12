<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'control';
    protected $primaryKey = 'idControl';
    public $timestamps = false;

    protected $fillable = [
        'idOF', 'idPersonnel', 'numeroJeton', 'testeur', 'epaisseur', 'diametre', 'couleur', 'dateControl', 'conformite'
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