<?php

namespace App\Models;

use App\Events\PretdocSaved;
use App\Events\PretdocUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pretdoc extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $dispatchesEvents = [
       /* 'saved' => PretdocSaved::class,
        'updated' => PretdocUpdated::class,*/
    ];

    protected $fillable = [
        'document_id',
        'date',
        'date_prevue',
        'date_reelle',
        'observation',
        'emprunteur',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'document_id' => 'integer',
        'date_prevue' => 'date',
        'date_reelle' => 'date',
    ];


    public function document()
    {
        return $this->belongsTo(\App\Models\Document::class);
    }

    public function imprimer(){
        return '<a class="btn  btn-link btn-success text-white" href="javascript:window.print();" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Imprimer</a>';
    }
}
