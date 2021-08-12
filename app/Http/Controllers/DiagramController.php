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
        $debut = $request->input('debut');
        $fin = $request->input('fin');
        $categorie_id = intval($request->input('categorie'),10);

        //dépenses par catégorie
        $depenses = $this->depense__par_categorie_totales($debut, $fin);
        $data = $this->getArray($depenses, 'sm');
        $data_get = $this->convert_to_int($data);
        $names=  $this->getArray($depenses, 'nom');

        //Pour les sous categorie catégories
        $sous_categorie = $this->depenses_par_sous_categorie($debut,$fin,$categorie_id);
        $s_categorie_names = $this->getArray($sous_categorie, 'designation');
        $s_categorie_values = $this->getArray($sous_categorie, 'sm');
        $s_categorie_values = $this->convert_to_int($s_categorie_values);


         return View('diagram',
            [
                'chart' => $chart->build($data_get, $names),
                'categories' => $this->get_categories(),
                's_categorie_chart' => $chart->build($s_categorie_values, $s_categorie_names),
                //'s_categorie_chart' => $chart->build([100,200], ["mmm","llll"]),
                'sous_categorie' => $this->get_sous_categorie($categorie_id),
                'categorie_id' => $categorie_id,
               
        ]);

    } 

}
