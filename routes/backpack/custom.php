<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('contact', 'ContactCrudController');
    Route::crud('categorie', 'CategorieCrudController');
    Route::crud('langue', 'LangueCrudController');
    Route::crud('document', 'DocumentCrudController');
    Route::crud('groupe', 'GroupeCrudController');
    Route::crud('type', 'TypeCrudController');
    Route::crud('depense', 'DepenseCrudController');
    Route::crud('domaine', 'DomaineCrudController');
    Route::crud('pretespece', 'PretespeceCrudController');
    Route::crud('empruntespece', 'EmpruntespeceCrudController');
    Route::crud('empruntdoc', 'EmpruntdocCrudController');
    Route::crud('revenu', 'RevenuCrudController');
    Route::crud('pretdoc', 'PretdocCrudController');
    Route::crud('typerevenu', 'TyperevenuCrudController');
    Route::crud('investissement', 'InvestissementCrudController');
}); // this should be the absolute last line of this file