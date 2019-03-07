
@auth
  <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">      

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

                
          @can('read_user') 

          <!-- ************************ Administrador | Acesso ********************* -->        

          <li class="header">Administrador | Acesso</li> 

          @endcan
          @can('read_user')
          
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i> <span>Usuários</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('users/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('users/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>

          @endcan

          @can('read_role')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-group"></i> <span>Roles (grupo)</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('roles/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('roles/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>

          @endcan

          @can('read_permission')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-lock"></i> <span>Permissions</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('permissions/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('permissions/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan

          @can('read_setor')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-black-tie"></i> <span>Setor de Trabalho</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('setors/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('setors/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan

          @can('read_log')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-history"></i> <span>Logs (Registros) Sistema</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('logs/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              <li><a href="{{ url('logs/acesso') }}"><i class="fa fa-circle-o"></i> Acesso</a></li>
            </ul>
          </li>
          @endcan

          @can('read_equipamento')

           <!-- ************************ Administrador | Configurações ********************* -->        

          <li class="header">Administrador | Configurações</li> 

          <li class="treeview">
            <a href="#">
              <i class="fa fa-wrench"></i> <span>Equipamentos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('equipamentos/dashboard') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
              <li><a href="{{ url('equipamentos/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('equipamentos/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan    

          @can('read_escala')
          <!--
          <li class="treeview">
            <a href="#">
              <i class="fa fa-male"></i> <span>Escalas Técnicas</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('escalas/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('escalas/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          -->
          @endcan    

          @can('read_ticket')

          <!-- ************************ Administrador | Tickets ********************* -->        

          <li class="header">Administrador | Tickets</li> 

          <li class="treeview">
            <a href="#">  
              <i class="fa fa-ticket"></i> <span>Tickets <i class="fa fa-certificate text-red"></i> Adm</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tickets/1/status') }}"><i class="fa fa-circle-o"></i> Abertos</a></li>
              <li><a href="{{ url('tickets/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
              <li><a href="{{ url('tickets/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              <li><a href="{{ url('tickets/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan   

          @can('read_livro')
          <!--
          <li class="treeview">
            <a href="#">
              <i class="fa fa-book"></i> <span>Livros de Serviço <i class="fa fa-certificate text-red"></i> Adm</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('livros/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
            </ul>
          </li>
          -->
          @endcan        

           
          
          @foreach((session()->get('setors')) as $sess_setors)

            @can('read_'.$sess_setors->name)             

              <li class="header">{{$sess_setors->label}}</li>

              
                <li class="treeview">
                  <a href="#">  
                    <i class="fa fa-tachometer"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/dashboard/') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
                  </ul>
                </li>

                <li class="treeview">
                  <a href="#">  
                    <i class="fa fa-ticket text-red"></i> <span>Tickets</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>

                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/tickets/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/tickets/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/tickets/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>

                    <li><a href="{{ url('tecnicos/'.$sess_setors->name.'/buscaData') }}"><i class="fa fa-circle-o"></i> Todos por Data</a></li>
                    
                  </ul>
                </li>



                <li class="treeview">
                  <a href="#">
                    <i class="fa fa-book"></i> <span>Livro de Serviço</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ url('livros/'.$sess_setors->name.'/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
                    <li><a href="{{ url('livros/'.$sess_setors->name.'/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
                  </ul>
                </li>

            @endcan 

          @endforeach 
          

          <!-- ************************ Cliente ********************* -->

          <li class="header">Cliente</li>

          <li class="treeview">
            <a href="#">  
              <i class="fa fa-ticket text-red"></i> <span>Tickets</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            
            <ul class="treeview-menu">
              <li><a href="{{ url('clients/create') }}"><i class="fa fa-circle-o text-red"></i> Novo</a></li>
              <li><a href="{{ url('clients/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
              <li><a href="{{ url('clients/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
              <li><a href="{{ url('clients/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              
            </ul>
          </li>          

          <!-- ************************ Atendimento ********************* -->

          <li class="header">Atendimento</li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-address-book"></i> <span>Contato</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('contato/') }}"><i class="fa fa-circle-o"></i> Enviar Mensagem</a></li>
            </ul>
          </li>
                   
          
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
  @endauth

  @guest
      <p>Erro: 400 | Você não tem permissão para acessar essa área.</p>
  @endguest