<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domaine extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

  /* public function investissement() //Folder model
    {
        return $this->hasMany(Investissement::class);
    }
*/
    public function create_invest(){
        $id = $this->id;
        return '<a class="btn btn-sm btn-link" href="http://127.0.0.1:8000/admin/investissement/create?id='.$id.'" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i> Ajouter </a>';
        
    }

    public function liste_invest(){
        return '<a class="btn btn-sm btn-link btn-primary" href="http://127.0.0.1:8000/admin/investissement/" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i> Consulter liste</a>';
    }

    public function imprimer(){
        return '<a class="btn  btn-link btn-success text-white" href="javascript:window.print();" data-toggle="tooltip" title="Just a demo custom button."><i class="fa fa-search"></i>Imprimer</a>';
    }

 

}
