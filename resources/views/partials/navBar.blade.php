<nav class="navbar navbar-expand-lg navbar-dark bg-main">  
  <img class="logo-navBar" src="{{asset('images/logo1.png')}}" alt="Logo EcuPets">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
     
      @if (auth()->guest())                
        <li class="nav-item">
          <a class="nav-link" href="{{URL::to('/')}}">Home</a>
        </li>        
      @endif

      @guest      
               
      @else          
        <li class="nav-item dropdown">            
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-user btn-sm"></i>                 
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"                  
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">                    
                Cerrar sesión
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{URL::to('/usuarios/editar/'.Auth::user()->id)}}">Mi perfil</a>            

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </div>
        </li>            
      @endguest  
            

      @if (auth()->guest()) 
     
      @endif
      <p class="font-size130p left top10px">
          <a class="text-black" href="https://www.facebook.com/oneprotech/" target="_blank"> 
              <i class="scaleIcon1-2 fa fa-facebook">
              </i>
          </a>
          <a class="text-black" href="https://www.instagram.com/onepro_tech/" target="_blank">
              <i class="scaleIcon1-2 fa fa-instagram left10px">
              </i>
          </a>
          <a class="text-black" href="https://twitter.com/oneprotech/" target="_blank">
              <i class="scaleIcon1-2 fa fa-twitter left10px">
              </i>
          </a>
      </p>

    </ul>

  </div>
</nav>



