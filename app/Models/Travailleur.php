<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travailleur extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'piece',
        'domaine_id',
        'localite',
        'date',
        'montant',
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
        'montant' => 'integer',
    ];


    public function domaine()
    {
        return $this->belongsTo(\App\Models\Domaine::class);
    }
}
