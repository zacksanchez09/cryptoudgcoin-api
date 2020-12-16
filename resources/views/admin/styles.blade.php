<!DOCTYPE html>

<html lang="es">
  <head>
    <base href="./">
    <meta charset="utf-8">

    <title>Panel Web - CryptoUDGCoin</title>
    <link rel="icon" type="image/png" href="{{ asset('img/icon.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link href="{{ asset('coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('coreui/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{asset('css/style 2.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/pace-progress/css/pace.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.standalone.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('admin.partials.header')
    <div class="app-body">
        @include('admin.partials.menu')
        <main class="main">

        @yield('content')

        </main>
        @include('admin.partials.aside')
    </div>

    @include('admin.partials.footer')

    <script src="{{ asset('coreui/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('coreui/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('coreui/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('coreui/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('coreui/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('coreui/coreui/dist/js/coreui.min.js') }}"></script>
    <script src="{{ asset('coreui/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js') }}"></script>
    <script src="{{asset('src/js/main.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.es.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>

    @stack('script')
</body>
</html>
