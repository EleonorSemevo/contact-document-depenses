<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categorie_id',
        'langue_id',
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
        'categorie_id' => 'integer',
        'langue_id' => 'integer',
    ];


    public function categorie()
    {
        return $this->belongsTo(\App\Models\Categorie::class);
    }

    public function langue()
    {
        return $this->belongsTo(\App\Models\Langue::class);
    }

    public function imprimer(){
        return '<a class="btn  btn-link btn-success text-white" href="javascript:window.print();" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Imprimer</a>';
    }
}
