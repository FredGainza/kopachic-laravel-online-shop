<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>Administration</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.4/css/adminlte.min.css">
  @yield('css')
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
      
    @font-face {
        font-family: 'roboto_condensedbold';
        src: url('../fonts/robotocondensed-bold-webfont.woff2') format('woff2'),
            url('../fonts/robotocondensed-bold-webfont.woff') format('woff'),
            url('../fonts/robotocondensed-bold-webfont.ttf') format('truetype'),
            url('../fonts/robotocondensed-bold-webfont.svg#roboto_condensedbold') format('svg');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'robotobold';
        src: url('../fonts/roboto-bold-webfont.woff2') format('woff2'),
            url('../fonts/roboto-bold-webfont.woff') format('woff'),
            url('../fonts/roboto-bold-webfont.ttf') format('truetype'),
            url('../fonts/roboto-bold-webfont.svg#robotobold') format('svg');
        font-weight: normal;
        font-style: normal;
    }

    .h1{
      font-size: 1rem !important;
    }

    .content-header h1 .fz-title {
        font-size: 2.5rem !important;
        margin: 0;
    }

    .style-card{
      background-color: #34495e;
      color: #ecf0f1;
    }

    .ptest{
      padding-top: .1rem;
    }

    .fz-90 {
      font-size: 90% !important;
    }

    .fz-110 {
      font-size: 110% !important;
    }

    .text-darky{
      color: #535c68;
    }

    .bg-menu{
      margin-bottom: .5rem !important;
      margin-top: .5rem !important;
      color: #fff !important;
      font-size: 110% !important;
    }

    .nav-pills .nav-link:not(.active):hover {
      color: rgba(171, 206, 198, 1) !important;
    }

    .nav-link.active,
    .show>.nav-link {
      color: #fff !important;
      background-color: #757575 !important;
    }

    .divide {
      border-bottom: 1px solid #4b545c;
    }

    .dash{
      padding: 0 .25rem !important;
    }
    .dashboard{
      font-size: 1.1rem;
      font-weight: 600;
    }

    .page-link {
      color: #292b2c !important;
      background-color: #fff !important;
      border: 1px solid #dee2e6 !important;
    }

    .page-link:hover {
      color: #292b2c !important;
      background-color: #e9ecef !important;
      border-color: #c7c7c7 !important;
    }

    .page-link:focus {
      box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25) !important;
    }

    .page-item.active .page-link {
      color: #fff !important;
      background-color: #292b2c !important;
      border-color: #c7c7c7 !important;
    }

    .page-item.disabled .page-link {
      color: #6c757d !important;
      background-color: #fff !important;
      border-color: #dee2e6 !important;
    }
        
    .btn-menu{
      padding: 0.075rem 0.15rem !important;
      font-size: .9rem !important;
    }

    table td {
      vertical-align: middle !important;
    }

    @media (min-width: 768px){
      .btn-menu{
        padding: .25rem .5rem !important;
        font-size: 1rem !important;
      }
    }

    div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter {
      width: 95% !important;
      display: block !important;
      text-align: start !important;
      margin-right: auto;
      margin-left: auto;
    }
    div.dataTables_wrapper div.dataTables_length{
      margin-bottom: 1rem;
    }
    /* div.dataTables_wrapper div.dataTables_filter{

    } */

    @media(min-width: 768px){
      div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter {
        width: 50% !important;
        display: inline-block !important;
        margin-bottom: .5rem;
      }
      div.dataTables_wrapper div.dataTables_length{
        text-align: left !important;
      }
      div.dataTables_wrapper div.dataTables_filter{
        text-align: right !important;
      }
    }

    div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
      width: 95% !important;
      display: block !important;
      text-align: left !important;
      margin-right: auto;
      margin-left: auto;
    }
    div.dataTables_wrapper div.dataTables_info{
      margin-top: -.1rem !important;
      margin-bottom: 1rem;
    }
    div.dataTables_wrapper div.dataTables_paginate{
      margin-top: .5rem;
      padding-bottom: 1rem;
    }
    div.dataTables_wrapper div.dataTables_paginate ul.pagination{
      justify-content: flex-start !important;
    }

    @media(min-width: 768px){
      div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {
        width: 50% !important;
        display: inline-block !important;
      }
      div.dataTables_wrapper div.dataTables_info{
        text-align: left !important;
      }
      div.dataTables_wrapper div.dataTables_paginate{
        text-align: right !important;
        margin-top: .5rem;
      }
      div.dataTables_wrapper div.dataTables_paginate ul.pagination{
      justify-content: flex-end !important;
      }
    }

    @media(min-width: 768px){
      .dash{
        padding: 0 .35rem !important;
      }
      .dashboard{
        font-size: 1.5rem;
        font-weight: 700;
      }
    }

  </style>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav d-flex align-items-center w-100">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('home') }}" class="nav-link">Voir la boutique</a>
        </li>
        <li class="nav-item mr-3 ml-auto text-right dash">
          <span class="text-darky dashboard">DASHBOARD</span>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav>
          <span class="text-white brand-link">
            <p class="text-uppercase bg-menu">
              <a href="{{ route('admin') }}">Tableau de bord&nbsp;&nbsp;
              <i class="right fas fa-tachometer-alt"></i></a>
            </p>
          </span>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">



            <li class="nav-item has-treeview pt-3 {{ menuOpen(
                'clients.index', 
                'clients.show', 
                'back.adresses.index', 
                'back.adresses.show' 
            )}}">
              <a href="#" class="nav-link {{ currentRouteActive(
                'clients.index', 
                'clients.show', 
                'back.adresses.index',
                'back.adresses.show'
                )}}">
                <i class="nav-icon fas fa-user-alt"></i>
                <p>
                  Clients
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-3">
                <x-menu-item :href="route('clients.index')" :sub=true :active="currentRouteActive('clients.index', 'clients.show')">
                  Clients
                </x-menu-item>
                <x-menu-item :href="route('back.adresses.index')" :sub=true :active="currentRouteActive('back.adresses.index', 'back.adresses.show')">
                  Adresses
                </x-menu-item>
              </ul>
            </li>


          <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link {{ currentRouteActive(
              'orders.index', 
              'orders.show',
            )}}">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Commandes
              </p>
            </a>
          </li>


            <li class="nav-item has-treeview {{ menuOpen(
                'produits.index',
                'produits.edit', 
                'produits.create',
                'produits.destroy.alert',
                'categories.index',
                'categories.edit',
                'categories.create',
                'categories.destroy.alert'
            ) }}">
              <a href="#" class="nav-link {{ currentRouteActive(
                'produits.index',
                'produits.edit',
                'produits.create',
                'produits.destroy.alert',
                'categories.index',
                'categories.edit',
                'categories.create',
                'categories.destroy.alert'
              ) }}">
                <i class="nav-icon fas fa-store"></i>
                <p>
                  Catalogue
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-3">
                <x-menu-item :href="route('categories.index')" :sub=true :active="currentRouteActive(
                  'categories.index', 
                  'categories.edit', 
                  'categories.create', 
                  'categories.destroy.alert'
                )">
                  Catégories
                </x-menu-item>
                <x-menu-item :href="route('produits.index')" :sub=true :active="currentRouteActive('produits.index', 'produits.edit' , 'produits.destroy.alert')">
                  Produits
                </x-menu-item>
                <x-menu-item :href="route('produits.create')" :sub=true :active="currentRouteActive('produits.create')">
                  Nouveau produit
                </x-menu-item>
              </ul>
            </li>

            <li class="nav-item has-treeview {{ menuOpen(
                'shop.edit',
                'shop.update',
                'pays.index',
                'pays.edit',
                'pays.create',
                'plages.edit',
                'colissimos.edit',
                'etats.index', 
                'etats.edit', 
                'etats.create', 
                'etats.destroy.alert',
                'pages.index',
                'pages.edit',
                'pages.create',
                'pages.destroy.alert',
                'maintenance.edit'
            ) }}">
              <a href="#" class="nav-link {{ currentRouteActive(
                'shop.edit',
                'shop.update',
                'pays.index',
                'pays.edit',
                'pays.create',
                'plages.edit',
                'colissimos.edit',
                'etats.index', 
                'etats.edit', 
                'etats.create', 
                'etats.destroy.alert',
                'pages.index',
                'pages.edit',
                'pages.create',
                'pages.destroy.alert',
                'maintenance.edit'
              ) }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                  Administration
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-3">

                <x-menu-item :href="route('shop.edit')" :sub=true
                  :active="currentRouteActive('shop.edit', 'shop.update')">
                  Boutique
                </x-menu-item>

                <x-menu-item :href="route('etats.index')" :sub=true :active="currentRouteActive(
                  'etats.index', 
                  'etats.edit', 
                  'etats.create', 
                  'etats.destroy.alert'
                )">
                  Etats de commande
                </x-menu-item>

                <x-menu-item :href="route('pays.index')" :sub=true :active="currentRouteActive(
                  'pays.index', 
                  'pays.edit',
                  'pays.create'
                )">
                  Pays
                </x-menu-item>

                <x-menu-item :href="route('pages.index')" :sub=true :active="currentRouteActive(
                  'pages.index',
                  'pages.edit',
                  'pages.create',
                  'pages.destroy.alert'
                )">
                  Pages
                </x-menu-item>

                <li class="nav-item has-treeview {{ menuOpen('plages.edit', 'colissimos.edit') }}">
                  <a href="#" class="nav-link {{ currentRouteActive('plages.edit', 'colissimos.edit') }}">
                    <i class="nav-icon far fa-circle"></i>
                    <p>
                      Expéditions
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview ml-3">
                    <x-menu-item :href="route('plages.edit')" :sub=false :subsub=true
                      :active="currentRouteActive('plages.edit')">
                      Plages
                    </x-menu-item>
                    <x-menu-item :href="route('colissimos.edit')" :sub=false :subsub=true
                      :active="currentRouteActive('colissimos.edit')">
                      Tarifs
                    </x-menu-item>

                  </ul>
                </li> 

                <x-menu-item :href="route('maintenance.edit')" :sub=true :active="currentRouteActive('maintenance.edit')">
                  Maintenance
                </x-menu-item>

                
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{ route('statistics', now()->year) }}" class="nav-link {{ currentRouteActive(
                'statistics',
              )}}">
                <i class="nav-icon fas fa-chart-bar"></i>
                <p>
                  Statistiques
                </p>
              </a>
            </li>
            <li>
              <div class="nav-item divide my-3"></div>
            </li>
            <li class="nav-item">
              <span>
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="nav-icon fas fa-home"></i>
                  BOUTIQUE
                </a>
              </span>
            </li>

          </ul>



          
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header py-3 py-lg-4 px-2">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="mt-0 ml-3 mr-0 mb-2 text-info"><i class="fas fa-caret-right fa-sm mr-2"></i>{{ $title }}</h1>
              <div class="show-on-large">
                <hr class="text-dark my-0">
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          @yield('main')
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- Default to the left -->
      <strong>Copyright &copy; 2020 {{ $shop->name }}.</strong>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.4/js/adminlte.min.js"></script>
  <script src="/js/chart.min.js"></script>
  <script src="/js/chartisan_chartjs.js"></script>
  @yield('js')
</body>

</html>