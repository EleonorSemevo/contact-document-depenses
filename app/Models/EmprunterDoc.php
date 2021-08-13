<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmprunterDoc extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'date_prevue',
        'date_reelle',
        'creancier',
        'motif',
        'observation',
        'titre',
        'sous_titre',
        'auteur',
        'co_auteur',
        'ISBN',
        'mots_cles',
        'resume',
        'annee_edition',
        'ville_edition',
        'lieu_edition',
        'nombre_page',
        'pp',
        'editeur',
        'edition',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'date_prevue' => 'date',
        'date_reelle' => 'date',
    ];
}
