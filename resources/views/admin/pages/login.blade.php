<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>92Agent | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet"  type="text/css"  href="{{ URL::asset('admin/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet"  type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet"  type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet"  type="text/css" href="{{ URL::asset('admin/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/plugins/iCheck/square/blue.css') }}">
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('/agentadmin')}}"><b>92</b>Agent</a>
  </div>
  <!-- /.login-logo -->
  
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><h4>Admin Login</h4></div>
                <div class="panel-body">
                    @if($errors->has('check'))
                        <div class="alert alert-danger text-center">{!! $errors->first('check') !!}</div>
                    @endif
                    {!! Form::open(array('method' => 'POST','url' => route('admin.login'),'class'=>'form-horizontal','role'=>'form')) !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">E-Mail</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


  <!-- /.login-box-body -->
</div>

<script  type="text/javascript" src="{{ URL::asset('admin/plugins/jQuery/jquery-3.1.1.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script  type="text/javascript" src="{{ URL::asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script  type="text/javascript" src="{{ URL::asset('admin/plugins/iCheck/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
