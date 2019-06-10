<header class="main-header" id="main-header">
    <!-- Logo -->
    <a href="{{ url('home/') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
          <img src="{{ asset('img/logo/favicon-transp.png') }}" width="70%">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ asset('img/logo/sicario-logo-branco-no-preto-sem-slogan-transp.png') }}" width="125"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Navegação</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          

              <li class="dropdown messages-menu" alt="Novo Ticket">
                <a href="{{url('clients/create')}}" class="dropdown-toggle">
                  <i class="fa fa-ticket"></i> + Ticket
                </a>
                
              </li>

              
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="{{ url('/home') }}" class="dropdown-toggle">
                  <i class="fa fa-home"></i>
                </a>
                
              </li>

              
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="{{ url('/contato') }}" class="dropdown-toggle">
                  <i class="fa fa-envelope"></i>
                </a>
                
              </li>
              <!-- Tasks: style can be found in dropdown.less --> 

              <!-- ------------------------------- Adm MENU ---------------------------------- -->
              @canany([
              'read_user',               
              'read_role', 
              'read_permission', 
              'read_setor',
              'read_log', 
              'read_equipamento', 
              'read_ticket',
              ])

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-cog"></i>                  
                  <span class="label label-info">!</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"></li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      
                      @can('read_user')
                      <li>
                        <a href="{{ url('users/') }}">
                          <i class="fa fa-user text-aqua"></i> Usuários
                        </a>
                      </li>
                      @endcan                      

                      @can('read_role')
                      <li>
                        <a href="{{ url('roles/') }}">
                          <i class="fa fa-group"></i> <span>Roles (grupo)</span>              
                        </a>            
                      </li>
                      @endcan

                      @can('read_permission')
                      <li class="treeview">
                        <a href="{{ url('permissions/') }}">
                          <i class="fa fa-lock"></i> <span>Permissions</span>              
                        </a>            
                      </li>
                      @endcan
                      
                      @can('read_setor')
                      <li class="treeview">
                        <a href="{{ url('setors/') }}">
                          <i class="fa fa-black-tie"></i> <span>Setores Internos</span>              
                        </a>            
                      </li>
                      @endcan

                      @can('read_log')
                      <li>
                        <a href="{{ url('logs/') }}">
                          <i class="fa fa-history"></i> Logs
                        </a>
                      </li>
                      @endcan

                      @can('read_log')
                      <li>
                        <a href="{{ url('logs/acesso') }}">
                          <i class="fa fa-history"></i> Logs de Acesso
                        </a>
                      </li>
                      @endcan

                      @can('read_equipamento')
                      <li>
                        <a href="{{ url('equipamentos/dashboard') }}">
                          <i class="fa fa-wrench"></i> <span>Equipamentos</span>              
                        </a>            
                      </li>
                      @endcan

                      @can('read_ticket')
                      <li>
                        <a href="{{ url('tickets/1/status') }}">  
                          <i class="fa fa-ticket"></i> <span>Tickets (Root)</span>                          
                        </a>                        
                      </li>
                      @endcan

                    </ul>
                  </li>
                </ul>
              </li>

              @endcanany
              
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">

                @php

                  $imagem_perfil = Auth::user()->uploads()->orderBy('id', 'DESC')->first();

                @endphp


                

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  @if($imagem_perfil)  
                        <img src="{{ url('storage/'.$imagem_perfil->dir.'/'.$imagem_perfil->link) }}" class="user-image" alt="User Image">
                  @else
                        <img src="{{ asset('img/default-user-image.png') }}" class="user-image" alt="User Image">
                  @endif
                  <span class="hidden-xs">{{ Auth::user()->cargo }} {{ Auth::user()->name_principal }}</span>
                </a>

                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    @if($imagem_perfil)  
                        <img src="{{ url('storage/'.$imagem_perfil->dir.'/'.$imagem_perfil->link) }}" class="img-circle" alt="User Image">
                    @else
                        <img src="{{ asset('img/default-user-image.png') }}" class="img-circle" alt="User Image">
                    @endif
                    

                    <p>
                      {{ Auth::user()->name }}
                      <!--<small></small>-->                      
                    </p>
                  </li>
                  <!-- Menu Body -->
                  
                  <li class="user-body">
                    <div class="row">
                      <div class="col-xs-4 text-center">
                        <a href="{{ url('clients/perfil') }}">Perfil</a>
                      </div>
                      <!--
                      <div class="col-xs-4 text-center">
                        <a href="#">Alterar Senha</a>
                      </div>
                      <div class="col-xs-4 text-center">
                        <a href="#">Score</a>
                      </div>
                      -->
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!--
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    -->
                    <div class="pull-right">

                      <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Sair') }}
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>


                    </div>
                  </li>
                </ul>

              
              </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->