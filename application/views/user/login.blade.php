@layout('main')

@section('title')
	User Authorization
@endsection

@section('sidebar')
	
@endsection

@section('content')

	<div class="half center">
		@if (isset($error))
			{{ Alert::info($error) }}
		@endif
		@if (isset($info))
			{{ Alert::info($info) }}
		@endif

		<h1>User Authorization</h1>
		<p>{{ Typography::muted('Please login to the system using form below.') }}</p>
		<hr/>

	<?  echo Form::horizontal_open();
		
		echo Form::control_group(
				Form::label('username','Username'),
				Form::prepend(Form::text('username',Input::old('username')), '<i class="icon-user"></i>'),
				($errors->first('username')) ? 'error':'',
				Form::block_help($errors->first('username'))
		);	

		echo Form::control_group(
				Form::label('password','Password'),
				Form::prepend(Form::password('password'), '<i class="icon-key"></i>'),
				($errors->first('password')) ? 'error':'',
				Form::block_help($errors->first('password'))
		);
	?>
		<br/>

		{{ Form::submit('Login', array('class'=>'btn-primary cntr')) }}

		{{ Form::close() }}
	</div>
@endsection