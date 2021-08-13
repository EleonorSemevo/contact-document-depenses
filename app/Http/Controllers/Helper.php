<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Groupe;
use App\Models\Type;
use DB;
use Carbon\Carbon;

class Helper 
{
    public function get_depenses_categorie_at($date)
    {
        $depenses = DB::table('depenses')
            ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
            ->whereDate('date', '=', $date)
            ->where('depenses.deleted_at','=',null)
            ->join('types', 'types.id', '=', 'depenses.type_id')
            ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
            ->groupBy('types.groupe_id')
            ->get();

        return $depenses;
    }

    public function get_depenses_categorie_between($debut, $fin)
    {
        $depenses = DB::table('depenses')
            ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
            ->whereBetween('date', [$debut, $fin])
            ->where('depenses.deleted_at','=',null)
            ->join('types', 'types.id', '=', 'depenses.type_id')
            ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
            ->groupBy('types.groupe_id')
            ->get();
        
        return $depenses;
    }

    public function get_sous_cat_fixe_at($date, $categorie_id)
    {
          $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->where('groupes.id','=',$categorie_id)
                ->whereDate('depenses.date','=',$date)
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();
            return $depenses;
    }

    public function get_sous_cat_fixe_between($debut, $fin, $categorie_id)
    {
         $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->whereBetween('depenses.date', [$debut, $fin])
                ->where('groupes.id','=',$categorie_id)
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();

                return $depenses;
    }

    public function get_all_sous_categorie($categorie_id)
    {
        
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

    public function get_sous_categorie(){
        $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'types.designation')
                ->where('depenses.deleted_at','=',null)
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('depenses.type_id')
                ->get();
                return $depenses;
    }

    
    public function get_depenses_categorie()
    {
        $depenses = DB::table('depenses')
                ->select(DB::raw("SUM(sommes) as sm"), 'groupes.nom')
                ->join('types', 'types.id', '=', 'depenses.type_id')
                ->where('depenses.deleted_at','=',null)
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('types.groupe_id')
                ->get();
        return $depenses;
    }

    
}
