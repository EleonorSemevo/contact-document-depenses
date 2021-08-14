<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmprunterDocRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\EmprunterDoc;
/**
 * Class EmprunterDocCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmprunterDocCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EmprunterDoc::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/emprunterdoc');
        CRUD::setEntityNameStrings('emprunterdoc', 'emprunt de documents');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
         $docs = EmprunterDoc::all();

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
        CRUD::column('date_prevue');
        CRUD::column('date_reelle');
        CRUD::column('creancier');
        CRUD::column('motif');
        CRUD::column('observation');
        CRUD::column('titre');
        CRUD::column('sous_titre');
        CRUD::column('auteur');
        CRUD::column('co_auteur');
        CRUD::column('ISBN');
        CRUD::column('mots_cles');
        CRUD::column('resume');
        CRUD::column('annee_edition');
        CRUD::column('ville_edition');
        CRUD::column('lieu_edition');
        CRUD::column('nombre_page');
        CRUD::column('pp');
        CRUD::column('editeur');
        CRUD::column('edition');

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
        CRUD::setValidation(EmprunterDocRequest::class);

         CRUD::addField(
            [   // date_picker
                'name'  => 'date',
                'type'  => 'date_picker',
                'label' => 'Date',

                // optional:
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'dd-mm-yyyy',
                    'language' => 'fr'
                ],
                ],
        );
       // CRUD::field('date');
       CRUD::addField(
            [   // date_picker
                'name'  => 'date_prevue',
                'type'  => 'date_picker',
                'label' => 'Date de retour prévue',

                // optional:
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'dd-mm-yyyy',
                    'language' => 'fr'
                ],
                ],
        );
        //CRUD::field('date_prevue');
        CRUD::addField(
            [   // date_picker
                'name'  => 'date_reelle',
                'type'  => 'date_picker',
                'label' => 'Date de retour',

                // optional:
                'date_picker_options' => [
                    'todayBtn' => 'linked',
                    'format'   => 'dd-mm-yyyy',
                    'language' => 'fr'
                ],
                ],
        );
        //CRUD::field('date_reelle');
        CRUD::field('creancier');
        CRUD::field('motif');
        CRUD::field('observation');
        CRUD::field('titre');
        CRUD::field('sous_titre');
        CRUD::field('auteur');
        CRUD::field('co_auteur');
        CRUD::field('ISBN');
        CRUD::field('mots_cles');
        CRUD::field('resume');
        CRUD::field('annee_edition');
        CRUD::field('ville_edition');
        CRUD::field('lieu_edition');
        CRUD::field('nombre_page');
        CRUD::field('pp');
        CRUD::field('editeur');
        CRUD::field('edition');

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
