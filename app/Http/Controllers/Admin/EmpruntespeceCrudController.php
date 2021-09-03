<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmpruntespeceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Empruntespece;

/**
 * Class EmpruntespeceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmpruntespeceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Empruntespece::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/empruntespece');
        CRUD::setEntityNameStrings('empruntespece', 'emprunts ');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $docs = Empruntespece::all();

           foreach($docs as $doc)
        {
            if($doc->date_reelle==null)
            {
                    if($doc->date_prevue >=  date('Y-m-d H:i:s'))
                {
                    $doc->status = "En cours";
                    $doc->save();
                }
                else if($doc->date_prevue <  date('Y-m-d H:i:s'))
                {
                    $doc->status = "En retard";
                    $doc->save();
                }

            }
            else
            {
                    $doc->status = "Payé";
                    $doc->save();
            }

        }




       
        $this->crud->addColumn([
        // Select
            'label'     => 'Status',
            'type'      => 'text',
            'name'      => 'status', 
            'attribute' => 'status', 
            'wrapper'   => [
            'element' => 'span', 
            
            'class' =>  function ($crud, $column, $entry, $related_key){
                    if ($column['text'] == 'En retard')
                    {
                        return 'badge bg-danger';
                    }
                    else if($column['text'] == 'En cours')
                    {
                        return 'badge bg-warning';
                    }
                    else if ($column['text'] == 'Payé')
                    {
                        return 'badge bg-success';
                    }
            },
            'style' => 'padding-top: 0.6rem; padding-bottom: 0.6rem; padding-right: 1rem;
            padding-left: 1rem; ',
            
            /*'href' => function ($crud, $column, $entry, $related_key) {
                return backpack_url('article/'.$related_key.'/show');
            },*/
            // 'target' => '_blank',
            // 'class' => 'some-class',
        ],
        ]);
   
        CRUD::column('date');
        CRUD::column('creancier');
        CRUD::column('montant');
        CRUD::column('motif');
        CRUD::column('date_prevue');
        CRUD::column('date_reelle');
        CRUD::column('obervation');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
        $this->crud->addButtonFromModelFunction('top', 'imprimer', 'imprimer');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmpruntespeceRequest::class);

        CRUD::field('date');
        CRUD::field('creancier');
        CRUD::field('montant');
        CRUD::field('motif');
        CRUD::field('date_prevue');
        CRUD::field('date_reelle');
        CRUD::field('obervation');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
