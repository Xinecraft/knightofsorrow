@extends('layouts.main')

@section('main-container')
<div class="content col-xs-9">
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading info-title">Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-xs-4 control-label">Username</label>
							<div class="col-xs-6">
								<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-4 control-label">Password</label>
							<div class="col-xs-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6 col-xs-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-6 col-xs-offset-4">
								<button type="submit" class="btn btn-primary login-btn">Login</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
