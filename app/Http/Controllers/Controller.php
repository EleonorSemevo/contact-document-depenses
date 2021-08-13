<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Groupe;
use App\Models\Type;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Helper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $helper;
    public function __construct(Helper $helper){
        $this->helper = $helper;
    }

    public function depense__par_categorie_totales($debut, $fin){
        
            
            
        if($debut != null && $fin != null){
                //les deux
                $depenses = $this->helper->get_depenses_categorie_between($debut, $fin);
        }

        else if ($debut ==null && $fin!=null) {
            //fin 
            $depenses = $this->helper->get_depenses_categorie_at($fin);
        }

        else
        if($debut!=null && $fin==null){
            //debut
            $depenses = $this->helper->get_depenses_categorie_at($debut);
        }

        else 
        {
            //rien
            $depenses = $this->helper->get_depenses_categorie();
        }

        return $depenses;

    }

    public function getArray($table, $attribut){
        $table_array=[];
        if($table==null)
            return [];
        foreach($table as $t)
        {
            array_push($table_array, $t->$attribut);
        }

        return $table_array;
    }

    public function convert_to_int($table){
       $table_converted = [];
        foreach($table as $table){
            array_push($table_converted, intval($table));
        }

        return $table_converted;
    }

    public function get_categories(){
         return Groupe::all()  ; 
    }

    public function depenses_par_sous_categorie($debut,$fin,$categorie_id){
        if($categorie_id==null || $categorie_id==-1)
        {
            return $this->helper->get_sous_categorie();
        }
        elseif($categorie_id=='investissement')
        {
            return null;
        }
        
        if($debut != null && $fin != null){
                //les deux
            $depenses = $this->helper->get_sous_cat_fixe_between($debut, $fin, $categorie_id);

            return $depenses;
        }

        else if ($debut ==null && $fin!=null) {

            
            $depenses = $this->helper->get_sous_cat_fixe_at($fin, $categorie_id);
            return $depenses;

        }

        else
        if($debut!=null && $fin==null){
            //debut
            $depenses = $this->helper->get_sous_cat_fixe_at($debut, $categorie_id);

            return $depenses;
        }

        else 
        {
            //rien
             $depenses =  $this->helper->get_all_sous_categorie($categorie_id);
                return $depenses;

        }
    }

    public function get_sous_categorie($categorie_id){
        
        return DB::table('types')
            ->where('groupe_id','=',$categorie_id)
            ->get();
    }

    public function get_investissement($debut,$fin){

        if($debut!=null && $fin!=null)
        {
           $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                    DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                    DB::raw("SUM(cout_transport) as transport"),
                     'domaines.nom')
                ->where('investissements.deleted_at','=',null)
                ->whereBetween('investissements.date', [$debut, $fin])
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->groupBy('investissements.domaine_id')
                ->get();
        }
        elseif ($debut!=null && $fin==null)
        {
            $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                    DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                    DB::raw("SUM(cout_transport) as transport"),
                     'domaines.nom')
                ->where('investissements.deleted_at','=',null)
                ->whereDate('investissements.date', '=', $debut)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->groupBy('investissements.domaine_id')
                ->get();
        }
        elseif ($debut==null && $fin!=null)
        {
            $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                    DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                    DB::raw("SUM(cout_transport) as transport"),
                     'domaines.nom')
                ->where('investissements.deleted_at','=',null)
                ->whereDate('investissements.date', '=', $fin)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->groupBy('investissements.domaine_id')
                ->get();
        }
        else 
        {
            $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                    DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                    DB::raw("SUM(cout_transport) as transport"),
                     'domaines.nom')
                ->where('investissements.deleted_at','=',null)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->groupBy('investissements.domaine_id')
                ->get();
        }

         
        return $investissements;
    }

    public function mettre_nom_depense_avec_investissement($nom_depenses, $investissements){
        foreach ($investissements as $inv )
        {
           array_push($nom_depenses, $inv->nom);
        }
        return $nom_depenses;
    }

    public function mettre_value_depense_avec_investissement($valeur_depenses, $investissements){
        foreach ($investissements as $inv )
        {
           array_push($valeur_depenses, $inv->intrant + $inv->oeuvre+ $inv->transport);
        }
        return $valeur_depenses;
    }

    public function get_all_sous_categorie()
    {

         $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->whereDate('depenses.date','=',$fin)
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();
            return $depenses;
    }

    public function getDepensesParMois(){
        $actuelle_annee = date("Y"); 

        $depenses_month = DB::table('depenses')->select(
            DB::raw("SUM(sommes) as sm"),
            DB::raw("strftime('%m', depenses.date) as month" ),
            DB::raw("strftime('%Y', depenses.date) as year"),
             'types.designation'
        )
        ->where('depenses.deleted_at','=',null)
        ->where('year', '=', "$actuelle_annee")
        ->join('types', 'types.id', '=', 'depenses.type_id')
        ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
        ->groupby('month','depenses.type_id')
        ->get();

       
        //return $depenses_month;
        return $this->helper->arranger($depenses_month, $this->getInvestissementParMmois());

    }

    public function getRevenusParMois(){
        $actuelle_annee = date("Y"); 

        $revenus = DB::table('revenus')
        ->select(DB::raw("SUM(montant) as sm"),
        DB::raw("strftime('%m', revenus.date) as month" ),
        DB::raw("strftime('%Y', revenus.date) as year"),
        'typerevenus.nom')
        ->whereYear('revenus.date', $actuelle_annee)
        ->where('revenus.deleted_at','=',null)
        ->join('typerevenus', 'typerevenus.id', '=', 'revenus.typerevenu_id')
        ->groupBy('month')
        ->get();

        //$rl= $this->helper->arranger_pour_line_chart();
        return $this->helper->arranger_pour_line_chart($this->getDepensesParMois(), $revenus);
        
    }

    public function getInvestissementParMmois(){
        $actuelle_annee = date("Y"); 

        $investissements = DB::table('investissements')
                ->select(DB::raw("SUM(cout_intrant) as intrant"),
                DB::raw("SUM(cout_main_oeuvre) as oeuvre"),
                DB::raw("SUM(cout_transport) as transport"),
                DB::raw("strftime('%m', investissements.date) as month" ),
                DB::raw("strftime('%Y', investissements.date) as year"),
                'domaines.nom')
                ->where('year', '=', "$actuelle_annee")
                ->where('investissements.deleted_at','=',null)
                ->join('domaines', 'domaines.id', '=', 'investissements.domaine_id')
                ->groupBy('month','investissements.domaine_id')
                ->get();
        return $investissements;
    }

}
