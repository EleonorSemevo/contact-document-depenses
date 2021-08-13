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

   /* public function array_data_en_mois_arrange($depenses){
        
        $table= [];
        for($i=0;$i<12;$i++){
            foreach($depenses as $dep)
            {
                if ($dep->month ==$i){
                    array_push($table, $dep->sm);
                    break;
                }

            }
            if(array_key_last($table)!=$i){
                 array_push($table, 0);
            }
        }
        return $table;
    }*/

    public function getvalues_depenses($depenses, $dep)
    {
        $table = [];
        for($i=0;$i<12;$i++){
            foreach($depenses as $depense)
            {
                if ($depense->month ==$i && $depense->designation == $dep->designation){
                    array_push($table, $depense->sm);
                    break;
                }

            }
            if(array_key_last($table)!=$i){
                 array_push($table, 0);
            }
        }
        return $table;


    }
    

    public function arranger($depenses,$investissements)
    {
        ///arrange la requette des sous catégories de telles maniere qu'elle puissu être itérée sur le chart
        $general = [];
        foreach ($depenses as $dep)
        {
            //prendres toutes ses valeurs
            $v = $this->getvalues_depenses($depenses,$dep);
            //l'arranger

            //stocer dans general
            array_push($general,array(
                'titre'=>$dep->designation,
                'values'=> $v
            ));
        }

        foreach ($investissements as $invest)
        {
            //prendres toutes ses valeurs
            $in = $this->getvalues_investissement($investissements,$invest);
            //l'arranger

            //stocer dans general
            array_push($general,array(
                'titre'=>$invest->nom,
                'values'=> $in
            ));
        }

       return $general;
    }

     public function getvalues_investissement($investissements, $invest)
    {
        $table = [];
        for($i=0;$i<12;$i++){
            foreach($investissements as $inv)
            {
                if ($inv->month ==$i && $inv->nom == $invest->nom){
                    array_push($table, $inv->intrant +$inv->oeuvre + $inv->transport );
                    break;
                }

            }
            if(array_key_last($table)!=$i){
                 array_push($table, 0);
            }
        }
        return $table;


    }

    public function arranger_pour_line_chart($depenses,$revenus)
    {
        ///arrange la requette des sous catégories de telles maniere qu'elle puissu être itérée sur le chart
        $general = $depenses;
        /*foreach ($depenses as $dep)
        {
            //prendres toutes ses valeurs
            $v = $this->getvalues_depenses($depenses,$dep);
            //l'arranger

            //stocer dans general
            array_push($general,array(
                'titre'=>$dep->designation,
                'values'=> $v
            ));
        }

        foreach ($investissements as $invest)
        {
            //prendres toutes ses valeurs
            $in = $this->getvalues_investissement($investissements,$invest);
            //l'arranger

            //stocer dans general
            array_push($general,array(
                'titre'=>$invest->nom,
                'values'=> $in
            ));
        }*/
        
            //prendres toutes ses valeurs
            $rev = $this->getvalues_revenus($revenus);
            //l'arranger

            //stocer dans general
            array_push($general,array(
                'titre'=>'revenus',
                'values'=> $rev
            ));
        
        return $general;
    }
    
     public function getvalues_revenus($revenus)
     {
        $table = [];
        for($i=0;$i<12;$i++){
            foreach($revenus as $rev)
            {
                if ($rev->month ==$i ){
                    array_push($table, $rev->sm );
                    break;
                }

            }
            if(array_key_last($table)!=$i){
                 array_push($table, 0);
            }
        }
        return $table;

     }


    
}
