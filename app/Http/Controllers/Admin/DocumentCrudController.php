<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DocumentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Langue;


/**
 * Class DocumentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DocumentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Document::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/document');
        CRUD::setEntityNameStrings('document', 'documents');
        
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('categorie_id');
        CRUD::column('langue_id');
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

        //POUR LES FILTRES

        //pour catégorie
        $this->crud->addFilter([
            'name'  => 'categorie_id',
            'type'  => 'dropdown',
            'label' => 'Categorie'
            ], [
            1 => 'Livre',
            2 => 'Article',
            3 => 'Texte',
            ], function($value) { // if the filter is active
            $this->crud->addClause('where', 'categorie_id', $value);
        });

        //filtre pour langue
        $langues = Langue::all('titre');
        $langues = $langues->toArray();
        $this->crud->addFilter([
            'name'  => 'langue_id',
            'type'  => 'dropdown',
            'label' => 'Langue'
            ], [
            1 => 'Anglais',
            2 => 'Français',
            3 => 'Hindi',
            4 => 'Espagnol',
            5 => 'Arabe',
            6 => 'Bengali',
            7 => 'Russe',
            8 => 'Portugais',
            9 => 'Indonésien',
            10 => 'Mandarin',], function($value) { // if the filter is active
            $this->crud->addClause('where', 'categorie_id', $value);

            $this->crud->enableExportButtons();
        });

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
        CRUD::setValidation(DocumentRequest::class);

        CRUD::field('categorie_id');
        CRUD::field('langue_id');
        CRUD::field('titre');
        CRUD::field('sous_titre');
        CRUD::field('auteur');
        CRUD::field('co_auteur');
        CRUD::field('ISBN');
        CRUD::field('mots_cles');

        CRUD::addField(
        [   // CKEditor
            'name'          => 'resume',
            'label'         => 'Resumé',
            'type'          => 'ckeditor'
        ]);

        //POUR GENERER LA PERIODE COMPRISE ENTRE 1900 ET L'ANNEE ACTUELLE

            $anne = date("Y");
            $years = [];

            for ($i=1900; $i<=$anne; $i++){
                $years[$i] = $i;
                
                
            }
        //



        CRUD::addField([
    // select_from_array
        'name'    => 'annee_edition',
        'label'   => 'Année d\'édition',
        'type'    => 'select_from_array',
        'options' => $years
        
        ]);
       // CRUD::field('annee_edition');
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
