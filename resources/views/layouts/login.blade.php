
<!DOCTYPE html>
<html>

  @include('layouts.head')

<body class="hold-transition login-page">

	@include('layouts.error')

	{{Session::get('danger')}}

	@yield('content')

</body>
</html>

<!-- jQuery 3 -->
<script src="../../abower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../abower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
