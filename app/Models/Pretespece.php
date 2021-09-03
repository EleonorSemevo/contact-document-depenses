<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pretespece extends Model
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
        'debiteur',
        'montant',
        'motif',
        'date_prevue',
        'date_reelle',
        'obervation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'date',
        'montant' => 'integer',
        'date_prevue' => 'date',
        'date_reelle' => 'date',
    ];

    public function imprimer(){
        return '<a class="btn  btn-link btn-success text-white" href="javascript:window.print();" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Imprimer</a>';
    }
}
