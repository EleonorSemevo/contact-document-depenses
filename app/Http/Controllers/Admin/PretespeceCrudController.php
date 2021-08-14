<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PretespeceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Pretespece;

/**
 * Class PretespeceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PretespeceCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Pretespece::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pretespece');
        CRUD::setEntityNameStrings('pretespece', 'pretespeces');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $docs = Pretespece::all();
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




        //CRUD::column('status')->type('text');
        $this->crud->addColumn([
  // Select
  'label'     => 'Status',
  'type'      => 'text',
  'name'      => 'status', // the db column for the foreign key
  //'entity'    => 'Pretespece', // the method that defines the relationship in your Model
  'attribute' => 'status', // foreign key attribute that is shown to user
  'wrapper'   => [
       'element' => 'span', // the element will default to "a" so you can skip it here
       
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
        CRUD::column('debiteur');
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
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PretespeceRequest::class);

        CRUD::field('date');
        CRUD::field('debiteur');
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
