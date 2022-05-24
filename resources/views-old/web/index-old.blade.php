<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no"> --}}

    {{-- Meta Data --}}
    <meta name="keywords" content="@yield('page_keywords', $page_keywords ?? '')" />
    <meta name="author" content="ramadan.marwan">
    <meta name="description" content="@yield('page_description', $page_description ?? '')"/>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">

    {{-- Global Theme Styles (used by all pages) --}}
@foreach(config('website.resources.css') as $style)
    <link href="{{ asset(config('website.template').$style) }}" rel="stylesheet" type="text/css"/>
@endforeach

    <!-- Bootstrap CSS -->


    {{-- <link href="{{ asset('css/all.css') }}" rel="stylesheet" type="text/css"/> --}}

    {{-- <link rel="stylesheet" href="css/bootstrap.min.css"> --}}

    <!-- Font Awesome -->
    {{-- <link href="css/all.css" rel="stylesheet"> --}}

    {{-- Fonts --}}
    {{ Web::getGoogleFontsInclude() }}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300&display=swap" rel="stylesheet"> --}}

    <!-- Bootstrap Custom CSS -->
    {{-- <link rel="stylesheet" href="css/font-styles.css"> --}}
    {{-- <link rel="stylesheet" href="css/style.css"> --}}

    {{-- <link href="css/mdtimepicker.css" rel="stylesheet" type="text/css"> --}}

    {{-- <link href="css/immersive-slider.css" rel='stylesheet' type="text/css"> --}}
    {{-- <link href="css/slider-csss.css" rel="stylesheet" type="text/css"> --}}

    {{-- <title>SAFWA Group</title> --}}
    <title>{{__('basic.app_title')}} | @yield('title', $page_title ?? '')</title>



</head>

<body>

    @include('web.layout.base._layout')


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

    {{-- Global Theme JS Bundle (used by all pages)  --}}
@foreach(config('website.resources.js') as $script)
    <script src="{{ asset(config('website.template').$script) }}" type="text/javascript"></script>
@endforeach

    {{-- <script src="js/all.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/mdtimepicker.js"></script>

    <script type="text/javascript" src="js/jquery.immersive-slider.js"></script> --}}

    <script>
      $(document).ready(function(){
        $('.timepicker').mdtimepicker(); //Initializes the time picker

        $("#immersive_slider").immersive_slider({
          container: ".main"
        });

      });
    </script>

    {{-- Includable JS --}}
    @yield('scripts')



</body>

</html>