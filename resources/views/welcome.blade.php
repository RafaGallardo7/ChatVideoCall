@extends('layouts.app')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">

<div class="container marketing top50px bottom60px">      
    <div class="col-md-12">
        <div class="card" align="center">
            <div class="card-header" id="map-header">
                <h3>Chat and VideoCall through Sockets </h3>
            </div>
            <div class="top10px" id="mapa-ecuador" style="height:72vh">  
                <div class="top50px" id="mapa-ecuador" style="height:72vh">  
                    <h4>Ingresa tu URL aquí</h4>
                    <form action="/validarUrl" style="width:80%;" method="POST">    
                        <div class="top20px">
                            <input class="form-control" type="text" id="url" name="url" required>
                        </div>
                        <div class="top20px">
                            <input class="btn btn-success" type="submit" value="Validar">
                        </div>                        
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>





@endsection



<script type="text/javascript"> 
    
</script>


@section('scripts')


@stop
