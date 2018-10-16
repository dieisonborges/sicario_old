
@auth
  <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">      

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

                
          @can('read_user')

          <!-- ************************ Administrador ********************* -->        

          <li class="header">Administrador</li> 

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

          @can('read_equipamento')

           <!-- ************************ Administrador ********************* -->        

          <li class="header">Configurações</li> 

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
          @endcan    

          @can('read_ticket')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-ticket"></i> <span>Tickets de Manutenção</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('tickets/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan   

          @can('read_livro')

          <li class="treeview">
            <a href="#">
              <i class="fa fa-book"></i> <span>Livros de Serviço</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ url('tickets/') }}"><i class="fa fa-circle-o"></i> Listar</a></li>
              <li><a href="{{ url('tickets/create') }}"><i class="fa fa-circle-o"></i> Novo</a></li>
            </ul>
          </li>
          @endcan  

          

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