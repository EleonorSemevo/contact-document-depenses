<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investissement extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domaine_id',
        'date',
        'numero_piece',
        'cout_intrant',
        'cout_main_oeuvre',
        'cout_transport',
        'prestataire',
        'mail',
        'telephone',
        'localite_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'domaine_id' => 'integer',
        'date' => 'date',
        'localite_id' => 'integer'
    ];


    public function domaine()
    {
        return $this->belongsTo(\App\Models\Domaine::class);
    }
    //
     public function localite()
    {
        return $this->belongsTo(\App\Models\Localite::class);
    }

    public function imprimer(){
        return '<a class="btn  btn-link btn-success text-white" href="javascript:window.print();" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Imprimer</a>';
    }
}
