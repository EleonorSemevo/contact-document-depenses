<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Backpack\CRUD\app\Models\Traits\CrudTrait;

class Emprunsdoc extends Model
{
    
    use HasFactory, SoftDeletes, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titre',
        'date',
        'preteur',
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
        'date_prevue',
        'date_reelle',
        'observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_prevue' => 'date',
        'date_reelle' => 'date',
    ];
}
