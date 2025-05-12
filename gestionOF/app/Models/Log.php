<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Log extends Model
{
    protected $table = 'log';
    protected $primaryKey = 'idLog';
    public $timestamps = false;

    protected $fillable = ['dateTime', 'action', 'interventionOF', 'idPersonnel', 'idOF'];

    public function personnel()
    {
        return $this->belongsTo(Personnel::class, 'idPersonnel');
    }

    public function ordreFabrication()
    {
        return $this->belongsTo(OrdreFabrication::class, 'idOF');
    }

    
    public static function ecrireLog($nom, $prenom, $typeAction, $idOF) {
        $log = new Log();
        $log->action = $typeAction;
    
        // Recherche du personnel avec nom et prénom
        $personnel = Personnel::where("nom", $nom)->where("prenom", $prenom)->first();
        if ($personnel) {
            $log->idPersonnel = $personnel->idPersonnel;
        } else {
            throw new \Exception("Personnel non trouvé");
        }
    
        // Recherche de l'Ordre de Fabrication
        $ordreFabrication = OrdreFabrication::where("idOF", $idOF)->first();
        if ($ordreFabrication) {
            $log->idOF = $ordreFabrication->idOF;
        } else {
            
            throw new \Exception("Ordre de fabrication non trouvé pour l'idOF : $idOF");
        }
    
        $log->save();
    }
    

}
