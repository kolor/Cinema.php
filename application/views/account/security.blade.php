@layout('main')

@section('title')
	User Profile
@endsection

@section('sidebar')
	<div class="short left">
		@render('account.sidebar')
	</div>
@endsection

@section('content')
	<div class="medium right">
		@if (isset($error))
			{{ Alert::info($error) }}
		@endif
		@if (isset($info))
			{{ Alert::info($info) }}
		@endif

		<h1>Change Password</h1>
		<p>{{ Typography::muted('You will have to provide registered e-mail address.') }}</p>
		<hr/>
		
	<?	echo Form::horizontal_open();

		echo Form::control_group(
				Form::label('email','Email'),
				Form::text('email')
		);

		echo Form::control_group(
				Form::label('password','New Password'),
				Form::password('password')
		);

	?>
		<br/>
		{{ Form::submit('Change', array('class'=>'btn-success cntr')) }}

		{{ Form::close() }}
	</div>
@endsection