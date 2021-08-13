<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groupe;
use App\Charts\ForPieChart;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request as DiagramRequest;



class DiagramController extends Controller
{
    public function index(ForPieChart $chart, DiagramRequest $request)
    {
        $debut = $request->input('date-debut');
        $fin = $request->input('date-fin');
         $categorie_id = $request->input('categorie'); 
        if ($categorie_id!=null && $categorie_id!='investissement')
        {
            $categorie_id = intval($categorie_id,10);
        }
        

        //dépenses par catégorie
        $depenses = $this->depense__par_categorie_totales($debut, $fin);
        $data = $this->getArray($depenses, 'sm');
        $data = $this->mettre_value_depense_avec_investissement($data, $this->get_investissement($debut,$fin));
        $data_get = $this->convert_to_int($data);
        $names=  $this->getArray($depenses, 'nom');
        $names = $this->mettre_nom_depense_avec_investissement($names, $this->get_investissement($debut,$fin));

        //Pour les sous categorie catégories
        $sous_categorie = $this->depenses_par_sous_categorie($debut,$fin,$categorie_id);
        $s_categorie_names = $this->getArray($sous_categorie, 'designation');
      //  $s_categorie_names = $this->mettre_nom_depense_avec_investissement($s_categorie_names,$this->get_investissement($debut,$fin));
        $s_categorie_values = $this->getArray($sous_categorie, 'sm');
       // $s_categorie_values = $this->mettre_value_depense_avec_investissement($s_categorie_values,$this->get_investissement($debut,$fin));
        
        if($categorie_id=='investissement')
        {
            $s_categorie_names = $this->mettre_nom_depense_avec_investissement($s_categorie_names,$this->get_investissement($debut,$fin));
            $s_categorie_values = $this->mettre_value_depense_avec_investissement($s_categorie_values,$this->get_investissement($debut,$fin));
        }
        $s_categorie_values = $this->convert_to_int($s_categorie_values);
        //Pour le diagramme en batton
        $band_data = $this->getDepensesParMois();
        $line_data = $this->getRevenusParMois();

         return View('diagram',
            [
                'chart' => $chart->build($data_get, $names),
                'categories' => $this->get_categories(),
                's_categorie_chart' => $chart->build($s_categorie_values, $s_categorie_names),
                //'s_categorie_chart' => $chart->build([100,200], ["mmm","llll"]),
                'sous_categorie' => $this->get_sous_categorie($categorie_id),
                'categorie_id' => $categorie_id,
                ///investissement
                /*'investissement'=> $this->get_investissement($debut, $fin),
                'debut' => $debut,
                'fin' => $fin,*/
                'getDepensesParMois' => $this->getDepensesParMois(),
                'band' => $chart->band($band_data),
                'line_diagramm' =>$chart->line_diagramm($line_data),
                'revenus' =>$this->getRevenusParMois(),
               
        ]);

    } 

}
