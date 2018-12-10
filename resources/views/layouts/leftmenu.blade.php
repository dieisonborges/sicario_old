
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
              <li><a href="{{ url('logs/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
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

          @can('read_tiop_supervisao')

          <!-- ************************ TIOP - Supervisor ********************* -->

          <li class="header">TIOP - Supervisor</li>

          
          <li class="treeview">
            <a href="#">  
              <i class="fa fa-tachometer"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tecnicos/tiop_supervisao/dashboard/') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
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
              <li><a href="{{ url('tecnicos/tiop_supervisao/tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>

              <li><a href="{{ url('tecnicos/tiop_supervisao/tickets/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
              <li><a href="{{ url('tecnicos/tiop_supervisao/tickets/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
              <li><a href="{{ url('tecnicos/tiop_supervisao/tickets/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              
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
              <li><a href="{{ url('livros/tiop_supervisao/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('livros/tiop_supervisao/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan 

          @can('read_tiop_hardware')

          <!-- ************************ TIOP - Hardware ********************* -->

          <li class="header">TIOP - Hardware</li>

          <li class="treeview">
            <a href="#">  
              <i class="fa fa-tachometer"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tecnicos/tiop_hardware/dashboard/') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
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
              <li><a href="{{ url('tecnicos/tiop_hardware/tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>

              <li><a href="{{ url('tecnicos/tiop_hardware/tickets/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
              <li><a href="{{ url('tecnicos/tiop_hardware/tickets/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
              <li><a href="{{ url('tecnicos/tiop_hardware/tickets/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              
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
              <li><a href="{{ url('livros/tiop_hardware/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('livros/tiop_hardware/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan
          

          @can('read_tiop_gbds')

          <!-- ************************ TIOP - GBDS - Base de Dados ********************* -->

          <li class="header">TIOP - GBDS - Base de Dados</li>

          <li class="treeview">
            <a href="#">  
              <i class="fa fa-tachometer"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tecnicos/tiop_gbds/dashboard/') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
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
              <li><a href="{{ url('tecnicos/tiop_gbds/tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>

              <li><a href="{{ url('tecnicos/tiop_gbds/tickets/1/status') }}"><i class="fa fa-circle-o text-yellow"></i> Abertos</a></li>
              <li><a href="{{ url('tecnicos/tiop_gbds/tickets/0/status') }}"><i class="fa fa-circle-o"></i> Fechados</a></li>
              <li><a href="{{ url('tecnicos/tiop_gbds/tickets/') }}"><i class="fa fa-circle-o"></i> Todos</a></li>
              
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
              <li><a href="{{ url('livros/tiop_gbds/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('livros/tiop_gbds/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan

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