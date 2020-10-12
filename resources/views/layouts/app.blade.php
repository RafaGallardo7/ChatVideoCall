<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>       
        @include('partials.header')                                            
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">     
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/> 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">              
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>             
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">                       
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">                        
        <link href="{{ asset('css/app_pruebas.css') }}" rel="stylesheet">        
    </head>
    <body>
        <div id="app">
            @include('partials.navBar')
            @yield('content')           
        </div>
        
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">                             
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>                
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>                                            
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        
        <script type="text/javascript">                                       
            $(function() {     
               
            });            
        </script>        
        
        @yield('scripts')
        @stack('scripts')
    </body>
    <footer>
        @include('partials.footer')
    </footer>
</html>
