<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdreFabrication extends Model
{
    protected $table = 'ordrefabrication';
    protected $primaryKey = 'idOF';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idOF',
        'dateDebut',
        'dateButoire',
        'boiteFilme',
        'nbreCaisse',
        'couleur',
        'nbreJetonParBoite',
        'nbreBoite',
        'idRecette',
        'idPersonnel',
        'idProgramme',
        'statut',
    ];

    public function recette()
    {
        return $this->belongsTo(Recette::class, 'idRecette');
    }

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'idPersonnel');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'idProgramme');
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'idOF');
    }

    public function controls()
    {
        return $this->hasMany(Control::class, 'idOF');
    }

    
    public function ficheLivraisons()
    {
        return $this->hasMany(FicheLivraison::class, 'idPersonnel');
    }

}
