<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $table = 'programme';
    protected $primaryKey = 'idProgramme';
    public $timestamps = false;

    protected $fillable = [
        'idProgramme',
        'boite',
        'positionBox',
        'positionRegul',
        'film',
        'nbreBriquette',
        'taillecaisse',
        'gravitaire',
    ];

    public function ordresFabrication()
    {
        return $this->hasMany(OrdreFabrication::class, 'idProgramme');
    }
}
