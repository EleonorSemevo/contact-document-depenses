<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\Localite;
use App\Models\Investissement;
use Carbon\Carbon;



class RapportController extends Controller
{
    public function index()
    {
        return View('rapport',
        [
            'data' => $this->getInvestissementParLocalite(),
            'total' => $this->getTotal(),
            'domaines' => $this->getAllDomaines(),

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

    public function getInvestissementParDomainePar()
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
                ->groupBy('investissements.localite_id','investissements.domaine_id','year')
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
}
