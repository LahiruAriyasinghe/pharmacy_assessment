<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AyuboHealth') }}
        @auth @isset(Auth::user()->hospital) &bull; {{Auth::user()->hospital->name}} @endisset @endauth
        &bull; @yield('title')
    </title>

    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.svg') }}" sizes="any" type="image/svg+xml">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;1,300;1,400;1,600&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Datatable -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
    <style>
    #page-content-wrapper {
        min-width: 100vw;
    }

    @media (min-width: 768px) {
        #page-content-wrapper {
            min-width: 0;
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <div id="app">
        <!-- Page Wrapper -->
        <div id="wrapper" class="d-flex" style="overflow-x: hidden;">
            <!-- Sidebar -->
            <!-- End of Sidebar -->
            <div id="page-content-wrapper">
                <!-- Topbar -->
                <!-- End of Topbar -->
                <!-- Main Content -->
                <div id="content">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Page Content Wrapper -->
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js">
        </script>
        <!-- App scripts -->
        @stack('scripts')
</body>

</html>