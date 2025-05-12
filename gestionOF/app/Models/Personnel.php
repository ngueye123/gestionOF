<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    protected $table = 'personnels';
    protected $primaryKey = 'idPersonnel';
    public $timestamps = false;

    protected $fillable = ['nom','prenom','email','mdp','role'];

    public function ordreFabrications()
    {
        return $this->hasMany(OrdreFabrication::class, 'idPersonnel');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'idPersonnel');
    }

    public function inventaires()
    {
        return $this->hasMany(Inventaire::class, 'idPersonnel', 'idPersonnel');
    }

    public function controls()
    {
        return $this->hasMany(Control::class, 'idPersonnel');
    }

    public function ficheLivraisons()
    {
        return $this->hasMany(FicheLivraison::class, 'idPersonnel');
    }
}
