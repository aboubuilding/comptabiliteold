<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('admin')}}/images/favicon.png">
    <link href="{{asset('admin')}}/vendor/wow-master/css/libs/animate.css" rel="stylesheet">
    <link href="{{asset('admin')}}/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin')}}/vendor/select2/css/select2.min.css">

    <link rel="stylesheet" href="{{asset('admin')}}/vendor/jquery-nice-select/css/nice-select.css">

    <link href="{{asset('admin')}}/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--swiper-slider-->

    <!-- Style css -->

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

    <link href="{{asset('admin')}}/css/style.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@latest/dist/ionicons/ionicons.js"></script>

    @yield('css')
</head>
<body>



<div id="main-wrapper">


    @include('components.navheader')
    @include('components.chatbox')

    @include('components.header')


    @yield('nav')

    @yield('contenu')




    <div class="footer out-footer style-2">
        <div class="copyright">
            <p>Copyright ©  <a href="" target="_blank">Ecole Internationale MARIAM </a>
                2024</p>
        </div>
    </div>





</div>

<!-- Required vendors -->
<script src="{{asset('admin')}}/vendor/global/global.min.js"></script>
<script src="{{asset('admin')}}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

@yield('js')

<script src="{{asset('admin')}}/vendor/select2/js/select2.full.min.js"></script>
<script src="{{asset('admin')}}/js/plugins-init/select2-init.js"></script>

<script src="{{asset('admin')}}/js/custom.min.js"></script>
<script src="{{asset('admin')}}/js/dlabnav-init.js"></script>
<script src="{{asset('admin')}}/js/demo.js"></script>
<script src="{{asset('admin')}}/js/styleSwitcher.js"></script>


</body>

</html>
