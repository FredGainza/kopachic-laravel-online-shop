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
    .nav-pills .nav-link:not(.active):hover {
      color: rgba(171,206,198,1) !important;
    }
    .nav-link.active, .show > .nav-link {
      color: #fff !important;
      background-color: #757575 !important;
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
  </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('home') }}" class="nav-link">Voir la boutique</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <x-menu-item 
            :href="route('admin')" 
            icon="tachometer-alt" 
            :active="currentRouteActive('admin')">
            Tableau de bord
          </x-menu-item>

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
                'etats.destroy.alert'
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
                'etats.destroy.alert'
              ) }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Administration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <x-menu-item :href="route('shop.edit')" :sub=true :active="currentRouteActive('shop.edit', 'shop.update')">
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

              <li class="nav-item has-treeview {{ menuOpen('plages.edit', 'colissimos.edit') }}">
                <a href="#" class="nav-link {{ currentRouteActive('plages.edit', 'colissimos.edit') }}">
                  <i class="nav-icon far fa-circle"></i>
                  <p>
                    Expéditions
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <x-menu-item :href="route('plages.edit')" :sub=false :subsub=true :active="currentRouteActive('plages.edit')">
                    Plages
                  </x-menu-item>
                  <x-menu-item :href="route('colissimos.edit')" :sub=false :subsub=true :active="currentRouteActive('colissimos.edit')">
                    Tarifs
                  </x-menu-item>
                </ul>
              </li>

            </ul>
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">{{ $title }}</h1>
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
@yield('js')
</body>
</html>
