<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  @include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <div class="col-md-2">
    <a href="/">
        <b style="display:none;">SICARIO</b>
        <br>
        <img src="{{ asset('img/logo/sicario-logo-branco-no-preto-sem-slogan-transp.png') }}" width="100%">
        
    </a>     
  </div>
   
 
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
