
@auth
  <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">      

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

          @php

          $color_p=0;

          @endphp
           
          
          @foreach((session()->get('setors')) as $sess_setors)

            @can('read_'.$sess_setors->name) 

            <li class="header">{{$sess_setors->label}}</li>

            @php

            //RRGGBB

            $color_p += 1;

            $color = array('','text-green','text-aqua','text-purple', 'text-light-blue', 'text-yellow');            

            @endphp

            <li class="treeview">
                  <a href="#">  
                    <i class="fa fa-tachometer {{$color[$color_p]}}"></i> <span>{{$sess_setors->label}}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li>
                      <a href="{{ url('tecnicos/'.$sess_setors->name.'/dashboard/') }}">  
                        <i class="fa fa-tachometer"></i> <span>Dashboard</span>                    
                      </a>
                      
                    </li>

                    <li>
                      <a href="{{ url('tecnicos/'.$sess_setors->name.'/tickets/') }}">
                        <i class="fa fa-ticket"></i> Tickets
                      </a>
                    </li>

                    <li>
                      <a href="{{ url('livros/'.$sess_setors->name.'/') }}">
                          <i class="fa fa-book"></i> Livros
                      </a>
                    </li>
                    
                    <li>
                      <a href="{{ url('tutorials/'.$sess_setors->name.'/') }}">
                          <i class="fa fa-graduation-cap"></i> Tutoriais
                      </a>
                    </li>                                 
                    
                  </ul>
            </li>              

            @endcan 

          @endforeach 
          

          <!-- ************************ Cliente ********************* -->

          <li class="header">Cliente</li>

          <li class="treeview">
            <a href="#">  
              <i class="fa fa-ticket"></i> <span>Tickets (Cliente)</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            
            <ul class="treeview-menu">
              <li><a href="{{ url('clients/create') }}"><i class="fa fa-circle-o text-red"></i> Novo</a></li>
              <li><a href="{{ url('clients/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
              <li><a href="{{ url('clients/0/status') }}"><i class="fa fa-circle-o text-green"></i> Fechados</a></li>
              <li><a href="{{ url('clients/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              
            </ul>
          </li>          

          <!-- ************************ Atendimento ********************* -->          
                   
          
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
  @endauth

  @guest
      <p>Erro: 400 | Você não tem permissão para acessar essa área.</p>
  @endguest