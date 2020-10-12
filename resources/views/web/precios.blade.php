@extends('layouts.app')
@section('content')


<div class="container-fluid">                    

    
    <div class="row">       
        <div class="top50px col-md-12" align="center">          
            <h2>Nuestros planes</h2>

            <hr/>
        </div>
    </div>

    

    <div class="top50px container-fluid">
        <div class="row">
            <div class="col-md-12" align="center">
                <div class="row">       
                    <div class="col-md-4" align="center">          
                        <h3><b>Plan Bronce</b></h3>
                        <h4>($2.20/month)</h4>
                        <span class="font-size320">
                            <img id="" class="services_icons pointer top20px" src="{{asset('images/price1.png')}}" alt="Servicio de consultoría">
                        </span>
                        <br>    
                        <!-- <h6 class="font-size110 text-bold top10px">UX / UI</h6> -->
                        <label class="font-size100 top40px">-Hasta 20 búsquedas únicas de fuentes de información</label><br>
                        <label class="font-size100">-Reportar noticias falsas</label><br>  
                        <label class="font-size100" style="color:#f00;text-decoration:line-through;">-Crear historial</label><br>
                        <label class="font-size100" style="color:#f00;text-decoration:line-through;">-Ingreso a comunidad de medios</label><br>
                        <label class="font-size100" style="color:#f00;text-decoration:line-through;">-Ahorras un 20%</label><br>                        

                        <div class="top20px col-md-12">
                            <button class="btn btn-success contacto" plan="1"><i class="fa fa-check"></i>Seleccionar</button>                   
                        </div>
                    </div>

                    <div class="col-md-4" align="center">          
                        <h3><b>Plan Plata</b></h3>
                        <h4>($3.60/month)</h4>
                        <span class="font-size320">
                            <img id="" class="services_icons pointer top20px" src="{{asset('images/price2.png')}}" alt="Servicio de consultoría">
                        </span>
                        <br>    
                        <!-- <h6 class="font-size110 text-bold top10px">UX / UI</h6> -->
                        <label class="font-size100 top40px">-Te permite realizar búsquedas ilimitadas por un mes</label><br>
                        <label class="font-size100">-Reportar noticias falsas</label><br>
                        <label class="font-size100">-Crear historial </label><br>     
                        <label class="font-size100" style="color:#f00;text-decoration:line-through;">-Ingreso a comunidad de medios</label><br>
                        <label class="font-size100" style="color:#f00;text-decoration:line-through;">-Ahorras un 20%</label><br>   

                        <div class="top20px col-md-12">
                            <button class="btn btn-success contacto" plan="2"><i class="fa fa-check"></i>Seleccionar</button>                   
                        </div>               
                    </div>

                    <div class="col-md-4" align="center">          
                        <h3><b>Plan Gold</b></h3>
                        <h4>($34.56/year)</h4>
                        <span class="font-size320">
                            <img id="" class="services_icons pointer top20px" src="{{asset('images/price3.png')}}" alt="Servicio de consultoría">
                        </span>
                        <br>    
                        <!-- <h6 class="font-size110 text-bold top10px">UX / UI</h6> -->
                        <label class="font-size100 top40px">-Te permite realizar búsquedas ilimitadas por un año</label><br>
                        <label class="font-size100">-Reportar noticias falsas.</label><br>
                        <label class="font-size100">-Crear historial</label><br>
                        <label class="font-size100">-Ingreso a comunidad de medios</label><br>
                        <label class="font-size100">-Ahorras un 20%</label><br>        

                        <div class="top20px col-md-12">
                            <button class="btn btn-success contacto" plan="3"><i class="fa fa-check"></i>Seleccionar</button>                   
                        </div>
                    </div>
                </div>
            </div>                   
        </div>
    </div>    

    <div class="container-fluid bottom50px">
        <div class="row">
            <div class="col-md-12" align="center">
                
            </div>                   
        </div>
    </div>    
                   
</div>

<div class="modal" id="ContactoForPlan">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Contáctanos para más información</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <form action="/contacto" style="" method="POST" onsubmit="return beforeSubmit();">           
        
        <div class="modal-body" align="center">        
                <div class="top10px">
                    <label>Nombres</label>
                    <input class="form-control" type="text" id="nombre" name="nombre" required>

                    <label>Email</label>
                    <input class="form-control" type="email" id="email" name="email" required>

                    <label>Teléfono</label>
                    <input class="form-control" type="number" id="telefono" name="telefono" required>

                    <input class="form-control" type="hidden" id="plan" name="plan">

                </div>        
        </div>

        <div class="modal-footer">        
            <button type="submit" id="send_contacto" class="btn btn-success mx-auto"><i class="fa fa-check"></i>Enviar</button>        
        </div>



      </form>       

    </div>
  </div>
</div>

<div class="modal" id="MensajeEnviadoExito">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Contacto</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="" align="center">
            <i class="fa fa-thumbs-up" style="font-size:500%; color:#33cc33;"></i>
        </div>
        <h4 class="top20px">Tu mensaje ha sido enviado con éxito</h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<input type="hidden" id="contacto" name="contacto" value="{{ $contacto }}">
@endsection

<style>
    
</style>





<script type="text/javascript"> 
    
</script>

@section('scripts')
<script type="text/javascript">  

    $(document).ready(function() {  
        var contacto = $('#contacto').val();

        if (contacto != 'Inicio') {
            if (contacto == 'Enviado') {
                $('#MensajeEnviadoExito').modal('show');                  

            }
        }  

        let plan = 0;

        function beforeSubmit() {
            plan = $(this).attr('plan');        
            
        }

        $(document).on('click', '.contacto', function(e){
            plan = $(this).attr('plan');
            document.getElementById('plan').value = plan;

            $('#ContactoForPlan').modal('show');  
        });

        $('body').on('hidden.bs.modal', function () {        
            location.replace("/pricing");  
        });
    
    });
  
</script>
@stop

<style>
   

</style>

@push('scripts')
<script type="text/javascript">

</script>
@endpush

