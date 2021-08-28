<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Localite;
use App\Models\Investissement;
use Carbon\Carbon;
use App\Models\Groupe;



class RapportController extends Controller
{
    public function index()
    {
        return View('rapport',
        [
            'data' => $this->getInvestissementParLocalite(),
            'total' => $this->getTotal(),
            'domaines' => $this->getAllDomaines(),
            'local_domaine' => $this->getInvestissementParDomaineParLocalite(),
            'type_groupes' => $this->getSelonCategorie(),
            'cat' => $this->categories(),

        ]);

    }

    public function getInvestissementParLocalite()
    {
       $actuelle_annee = date("Y"); 

        $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                DB::raw("SUM(cout_transport) as transport"),
                //DB::raw("strftime('%m', investissements.date) as month" ),
                DB::raw("strftime('%Y', investissements.date) as year"),
                'domaines.nom as domaine',
                'localites.nom as localite',
                'domaines.id')
                ->where('year', '=', "$actuelle_annee")
                ->where('investissements.deleted_at','=',null)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->join('localites', 'localites.id', '=', 'investissements.localite_id')
                ->groupBy('investissements.localite_id','year')
                ->get();
        return $investissements;
    }

    public function getInvestissementParDomaineParLocalite()
    {
       $actuelle_annee = date("Y"); 

        $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                DB::raw("SUM(cout_transport) as transport"),
                //DB::raw("strftime('%m', investissements.date) as month" ),
                DB::raw("strftime('%Y', investissements.date) as year"),
                'domaines.nom as domaine',
                'localites.nom as localite',
                'investissements.domaine_id as domaine_id',
                'investissements.localite_id as localite_id',
                'prestataire')
                ->where('year', '=', "$actuelle_annee")
                ->where('investissements.deleted_at','=',null)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->join('localites', 'localites.id', '=', 'investissements.localite_id')
                ->groupBy('investissements.localite_id',
                    'investissements.domaine_id',
                    'year','prestataire')
                ->get();
        return $investissements;
    }

    public function getTotal()
    {
        $investissements = $this->getInvestissementParLocalite();
        $total = 0;
        foreach($investissements as $inv)
        {
            $total= $total + intval($inv->intrant,10) + intval($inv->oeuvre,10) + intval($inv->transport,10);
        }

        return $total;
    }

    public function getAllDomaines()
    {
        return DB::table("domaines")->get();
    }

    public function arranger(){
        $data= [];
        $valeurs = $this->getInvestissementParDomaineParLocalite();

        foreach($valeurs as $valeur)
        {
            if(! $this->existe_deja($data, $valeur))
            {
                $valeur.push([
                    'localite_id' => $valeur->localite_id,
                    'domaine_id' => $valeur->domaine_id,
                    'domaine'  => $valeur->domaine,
                    'localite'  => $valeur->localite,
                    'oeuvre'  => $valeur->oeuvre,
                    'transport'  => $valeur->transport,
                    'intrant'  => $valeur->intrant
                ]);
            }
        }



    }

    public function faire_sum($table, $valeur, $data)
    {
        $sum_oeuvre=0;
        $sum_intrant=0;
        $sum_transport=0;

         foreach($table as $tab)
        {
            if($tab->domaine_id == $valeur->$domaine_id &&
                $tab->localite_id == $valeur->$localite_id)
            {
                $sum_oeuvre += $tab->oeuvre;
                $sum_intrant +=$tab->intrant;
                $sum_transport +=$tab->transport;
            }

           
        }
    }

    public function existe_deja($table,$valeur){
        foreach($table as $tab)
        {
            if($tab->domaine_id == $valeur->$domaine_id &&
                $tab->localite_id == $valeur->$localite_id)
            {
                return true;
            }

           
        }
        return false;
    }

    ///
    public function getTypesParCartegorie(int $id){
        $actuelle=[]; 

        $typesCartegorie = DB::table('types')
                ->select('designation'
                )
                ->where('groupe_id','=',$id)
                
                ->get();
        
                foreach($typesCartegorie as $tab )
                {
                    array_push($actuelle, $tab->designation);
                }
                return $actuelle;
    }

    public function categories()
    {
        return DB::table('groupes')->get();
         
    }

    public function getSelonCategorie()
    {
        $table=[];
        $categories = $this->categories();

        foreach($categories as $category)
        {
            array_push($table, ["categorie" => $category->nom, "types" =>  $this-> getTypesParCartegorie($category->id)] );
        }

        return $table;
    }


}
