<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;

class DepenseController extends Controller
{

     
    public function depense_totales() {
       $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->join('types', 'types.id', '=', 'depenses.type_id')
        ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
        ->groupBy('types.groupe_id')
        ->get();
        
        //return View('financeoperation')->with('depenses', $depenses);
        $date_debut = null;
        $date_fin = null;

        //totale des sommes
        $total = 0;
        foreach($depenses as $depense){
            $total+= $depense->sm;
        }

        return View('financeoperation', ['depenses' => $depenses, 'date_debut' => $date_debut, 'date_fin' => $date_fin, 'total' => $total]);
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     

    public function depenses_mois(Request $request){
        
			$data = $request->all();
            
            $date_debut = $request->input('debut');
            $date_fin = $request->input('fin');

            if($date_debut != null && $date_fin != null){
                    //les deux
                    $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->whereBetween('date', [$date_debut, $date_fin])->join('types', 'types.id', '=', 'depenses.type_id')
                    ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                    ->groupBy('types.groupe_id')
                    ->get();
            }
            else if ($date_debut ==null && $date_fin!=null) {

                //date_fin 
                $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->whereDate('date', '=', $date_fin)->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('types.groupe_id')
                ->get();

            }

            else
            if($date_debut!=null && $date_fin==null){
                //date_debut
                $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->whereDate('date', '=', $date_debut)->join('types', 'types.id', '=', 'depenses.type_id')
                ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                ->groupBy('types.groupe_id')
                ->get();
            }

            else 
            
            {
                    //rien
                $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->join('types', 'types.id', '=', 'depenses.type_id')
                    ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
                    ->groupBy('types.groupe_id')
                    ->get();
            }

            $total = 0;
            foreach($depenses as $depense){
                $total+= $depense->sm;
            }
           

       return View('financeoperation', ['depenses' => $depenses, 'date_debut' => $date_debut, 'date_fin' => $date_fin, 'total' => $total]);
			
    }
}

 