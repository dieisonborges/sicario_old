
@guest
  <script type="text/javascript">
      window.location = "/"; 
  </script>
        
@else

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- TOP MENU -->
  @include('layouts.topmenu')
  <!-- END TOP MENU -->
  
  <!-- LEFT MENU -->
  @include('layouts.leftmenu')
  <!-- END LEFT MENU -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <section class="content">  

      <div class="row">

          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">

                @include('layouts.error')

                @yield('content')
              </div>
            </div>
            
          </div>          

      </div>


    </section>
    <!-- /.content -->
  </div>


  @include('layouts.footer')

  
</div>
<!-- ./wrapper -->

@include('layouts.scripts')

</body>
</html>

 @endguest  
