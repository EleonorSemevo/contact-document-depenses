<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investissement extends Model
{
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
        'localite',
        'cout_intrant',
        'cout_main_oeuvre',
        'cout_transport',
        'prestataire',
        'mail',
        'telephone',
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
    ];


    public function domaine()
    {
        return $this->belongsTo(\App\Models\Domaine::class);
    }
}
