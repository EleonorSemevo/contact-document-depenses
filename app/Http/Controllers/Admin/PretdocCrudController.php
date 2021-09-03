<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PretdocRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Pretdoc;

/**
 * Class PretdocCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PretdocCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Pretdoc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pretdoc');
        CRUD::setEntityNameStrings('pretdoc', 'prêt de documents');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $docs = Pretdoc::all();
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
      
        CRUD::column('document_id');
        CRUD::column('date');
        CRUD::column('date_prevue');
        CRUD::column('date_reelle');
        CRUD::column('observation');
        CRUD::column('emprunteur');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
         /*$this->crud->addColumn([
             'label' => 'status',
             'type' => 'boolean',
             'name' => 'status',
             'options' =>[true=>'oui', false=>'non'],
             'content' =>[
                 'header' => 'Something',
                 'body' => 'Lorem',
                ],
             'wrapper' => [
                 'class' => 'badge',
                 'style' => 'bg-success',
             ],
         ]
        );*/
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
        CRUD::setValidation(PretdocRequest::class);

        CRUD::field('document_id');
        CRUD::field('date');
        CRUD::field('date_prevue');
        CRUD::field('date_reelle');
        CRUD::field('observation');
        CRUD::field('emprunteur');

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
