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
                ////
                'intro' => $this->get_investissement_par_annees(2021),
                //'intro_arranger' => $this->arranger_investissement_par_mois(),
                'rev_yearly' => $this->get_revenu_par_annee(2021), //revenus par année
                'dep_yearly' => $this->get_depenses_Par_annee(2021), //array direct de depenses sans nvestissement
                'to_compare' =>$this->get_values_for_comparison_chart(2021),//depense = nvestissement+depenses par mois par année
                'chartjs' =>$this->exemp(), 
                'bande_line_chart' => $this->line_bande(),
                
            ]);
            
 
    } 

    public function line_bande()
    {
        $annee_en_cours = date("Y");
        $revenu_annee_en_cours = $this->get_revenu_par_annee($annee_en_cours) ;
        $depenses_il_y_a_deux_annees = $this->get_values_for_comparison_chart($annee_en_cours-2) ;
        $depenses_il_y_a_une_annees = $this->get_values_for_comparison_chart($annee_en_cours-1) ;
        $depenses_il_y_a_trois_annees = $this->get_values_for_comparison_chart($annee_en_cours-3) ;
        $depenses_annees_en_cours = $this->get_values_for_comparison_chart($annee_en_cours) ;;





        $bande_line_chart = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'])
        ->datasets([
            [
                "type" => 'bar',
                "label" => "Revenues en ".date("Y"),
                'backgroundColor' => "rgba(38, 185, 154, 0.7)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                //'data' => $revenu_annee_en_cours,
                'data' => [14,20,30,14,58,74,47,56,78, 45,25,14]
            ],
            [
                "type" => 'bar',
                "label" => "Dépenses de ".$annee_en_cours,
                'backgroundColor' => "rgba(37, 51, 40, 0.7)",
                'borderColor' => "rgba(37, 51, 190, 0.7)",
                "pointBorderColor" => "rgba(37, 51, 40, 0.7)",
                "pointBackgroundColor" => "rgba(37, 51, 40, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
               // 'data' => $depenses_annees_en_cours,
               'data' => [36,20,30,14,65,74,47,56,78, 45,25,14]
            ],
            [
                "type" => 'line',
                "label" => "Dépenses de ".($annee_en_cours-1),
                'backgroundColor' => "rgba(55, 201, 10, 0.7)",
                'borderColor' => "rgba(55, 201, 10, 0.9)",
                "pointBorderColor" => "rgba(55, 201, 10, 0.9)",
                "pointBackgroundColor" => "rgba(55, 201, 10, 0.9)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                //'data' => $depenses_il_y_a_une_annees,
                'data' => [14,30,30,14,58,40,47,56,78, 45,25,14]
            ],
            [
                "type" => 'line',
                "label" => "Dépenses de ".($annee_en_cours-2) ,
                'backgroundColor' => "rgba(16, 10, 201, 0.9)",
                'borderColor' => "rgba(16, 10, 201, 0.9)",
                "pointBorderColor" => "rgba(16, 10, 201, 0.9)",
                "pointBackgroundColor" => "rgba(16, 10, 201, 0.9)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                //'data' => $depenses_il_y_a_deux_annees ,
                'data' => [64,25,30,36,45,39,40,45,46, 45,25,14]
            ],
            [
                "type" => 'line',
                "label" => "Dépenses de ".($annee_en_cours-3) ,
                'backgroundColor' => "rgba(237, 102, 5, 0.9)",
                'borderColor' => "rgba(237, 102, 5, 0.9)",
                "pointBorderColor" => "rgba(237, 102, 5, 0.9)",
                "pointBackgroundColor" => "rgba(237, 102, 5, 0.9)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                //'data' => $depenses_il_y_a_trois_annees ,
                'data' => [30,25,30,36,45,55,40,45,46, 45,45,14]
            ]
        ])
        ->options([]);

        //return view('chartjs', compact('chartjs'));
        return $bande_line_chart;
    }

     
}
