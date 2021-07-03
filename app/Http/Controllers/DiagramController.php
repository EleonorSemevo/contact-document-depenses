<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;

use Validator;
use DB;
use Carbon\Carbon;


class DiagramController extends Controller
{
    public function diagram(){
        
        $actuelle_annee = date("Y"); 

        $depenses = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), 'nom')->whereYear('date', $actuelle_annee)->join('types', 'types.id', '=', 'depenses.type_id')
        ->join('groupes', 'groupes.id', '=', 'types.groupe_id')
        ->groupBy('types.groupe_id')
        ->get();

       /* $depenses_month = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), "Month('date')  as  month")->whereYear('date', $actuelle_annee)
        ->groupBy('month')
        ->get();*/

        $depenses_month = DB::table('depenses')->select(
            DB::raw("SUM(sommes) as sm"),
            DB::raw(
                 "strftime('%m', date) as month" ),
             DB::raw("strftime('%Y', date) as year")
        )
        ->where('year', '=', "$actuelle_annee")
            ->groupby('month')
            ->get();
        
        foreach ($depenses_month as $vale){
                if( intval($vale->month)==1)
                    $vale->month = "Janvier";
                elseif (intval($vale->month)==2)
                    $vale->month = "Février";
                elseif (intval($vale->month)==3)
                    $vale->month = "Mars";
                elseif (intval($vale->month)==4)
                    $vale->month = "Avril";
                elseif (intval($vale->month)==5)
                    $vale->month = "Mai";
                elseif (intval($vale->month)==6)
                    $vale->month = "Juin";
                elseif (intval($vale->month)==7)
                    $vale->month = "Juillet";
                elseif (intval($vale->month)==8)
                    $vale->month = "Août";
                elseif (intval($vale->month)==9)
                    $vale->month = "Septembre";
                elseif (intval($vale->month)==10)
                    $vale->month = "Octobre";
                elseif (intval($vale->month)==11)
                    $vale->month = "Novembre";
                elseif (intval($vale->month)==12)
                    $vale->month = "Décembre";
        }
         /*foreach ($depenses_month as $vale)
                $vale->month = intval($vale->month);*/
        

        //return view('diagram', compact('depenses'));
        return View('diagram', ['depenses' => $depenses, 'depenses_month'=>$depenses_month]);

    }

    public function diagram_mois(){
        
        $actuelle_annee = date("Y"); 

        $depenses_month = DB::table('depenses')->select(DB::raw("SUM(sommes) as sm"), "monthname(date)  as  month")->whereYear('date', $actuelle_annee)
        ->groupBy('month')
        ->get();
        

        return view('diagram', compact('depenses'));

    }



}
