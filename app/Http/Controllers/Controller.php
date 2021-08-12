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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function depense__par_categorie_totales($debut, $fin){
        
            
            
        if($debut != null && $fin != null){
                //les deux
                $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
                ->whereBetween('date', [$debut, $fin])
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '!=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('types.groupe_id')
                ->get();
        }

        else if ($debut ==null && $fin!=null) {

            //fin 
            $depenses = DB::table('depenses')
            ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
            ->whereDate('date', '=', $fin)
            ->where('depenses.deleted_at','!=',null)
            ->join('types', 'types.id', '=', 'depenses.type_id')
            ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
            ->groupBy('types.groupe_id')
            ->get();

        }

        else
        if($debut!=null && $fin==null){
            //debut
            $depenses = DB::table('depenses')
            ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
            ->whereDate('date', '=', $debut)
            ->where('depenses.deleted_at','!=',null)
            ->join('types', 'types.id', '=', 'depenses.type_id')
            ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
            ->groupBy('types.groupe_id')
            ->get();
        }

        else 
        {
                //rien
            $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->where('depenses.deleted_at','=',null)
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('types.groupe_id')
                ->get();
        }

        return $depenses;

    }

    public function getArray($table, $attribut){
        $table_array=[];
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
         if($debut != null && $fin != null){
                //les deux
                $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->whereBetween('date', [$debut, $fin])
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();

                return $depenses;
        }

        else if ($debut ==null && $fin!=null) {

            //fin 
            /*$depenses = DB::table('depenses')
            ->select(DB::raw("SUM(sommes) as sm"), 'types.designation' )
            ->whereDate('date', '=', $fin)
            ->where('groupes.id','=',$categorie_id)
            ->where('depenses.deleted_at','=',null)
            ->join('types', 'types.id', '!=', 'depenses.type_id')
            ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
            ->groupBy('depenses.type_id')
            ->get();
            */

            $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->where('groupes.id','=',$categorie_id)
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();
            return $depenses;

        }

        else
        if($debut!=null && $fin==null){
            //debut
            $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->whereDate('date', '=', $debut)
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();

            return $depenses;
        }

        else 
        {
            //rien
             $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
            
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();

                return $depenses;

        }
    }

    public function get_sous_categorie($categorie_id){
        
        return DB::table('types')
            ->where('groupe_id','=',$categorie_id)
            ->get();
    }

}
