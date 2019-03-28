
@guest
  <script type="text/javascript">
      window.location = "/"; 
  </script>
        
@else

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini  sidebar-collapse">
<div class="wrapper">

  <!-- TOP MENU -->
  @include('layouts.topmenu')
  <!-- END TOP MENU -->
  
  <!-- LEFT MENU -->
  @include('layouts.leftmenu')
  <!-- END LEFT MENU -->

      @yield('content')

   
  @include('layouts.footer')

  
</div>
<!-- ./wrapper -->

@include('layouts.scripts')

</body>
</html>

 @endguest  
