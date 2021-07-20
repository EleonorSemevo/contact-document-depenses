<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact') }}'><i class='nav-icon lar la-address-book'></i> Mes contacts</a></li>

<!-- Users, Roles, Permissions -->

@if(backpack_user()->hasRole('administration'))
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endif
@if(backpack_user()->hasRole('administration'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('categorie') }}'><i class='nav-icon la la-question'></i> Categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('langue') }}'><i class='nav-icon la la-question'></i> Langues</a></li>

@endif


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-store-alt"></i>Documents</a>
    <ul class="nav-dropdown-items">

    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('document') }}'><i class='nav-icon las la-folder'></i>Mes Documents</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pretdoc') }}'><i class='nav-icon la la-question'></i> Docs Prêtés</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('emprunsdoc') }}'><i class='nav-icon la la-question'></i> Docs Empruntés</a></li>
</ul>
</li>


@if(backpack_user()->hasRole('administration'))
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('groupe') }}'><i class='nav-icon la la-question'></i> Groupes</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('type') }}'><i class='nav-icon la la-question'></i> Types</a></li>
@endif


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-store-alt"></i> Finances</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('depense') }}"><i class="nav-icon las la-coins"></i> <span>Mes dépenses</span></a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('typerevenu') }}'><i class='nav-icon la la-question'></i> Type revenus</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('revenu') }}'><i class='nav-icon la la-question'></i> Revenus</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('emprunsespece') }}'><i class='nav-icon la la-question'></i> Empruns </a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pretespece') }}'><i class='nav-icon la la-question'></i> Prêts</a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('operation')}}"><i class="nav-icon la la-id-badge"></i> <span>Filtrer</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('operation/statistiques') }}"><i class="nav-icon las la-chart-area"></i> <span>Graphes</span></a></li>
    </ul>
</li>

<!--
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('depense') }}'><i class='nav-icon la la-question'></i> Depenses</a></li>
-->

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon las la-store-alt"></i> Immobiliers</a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('domaine') }}'><i class='nav-icon la la-question'></i> Domaines</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('travailleur') }}'><i class='nav-icon la la-question'></i> Travailleurs</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('intrant') }}'><i class='nav-icon la la-question'></i> Intrants</a></li> 
    </ul>
</li>


