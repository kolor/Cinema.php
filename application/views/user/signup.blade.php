@layout('main')

@section('title')
	User Registration
@endsection

@section('sidebar')
	
@endsection

@section('content')

	<div class="half center">
		<h1>User Registration</h1>
		<p>{{ Typography::muted('Registering account is fast and easy. Just fill in the form and you are good to go.') }}</p>
		<hr/>
	
	<?	echo Form::horizontal_open();
		
		echo Form::control_group(
				Form::label('username','Username'),
				Form::prepend(Form::text('username',Input::old('username')), '<i class="icon-user"></i>'),
				($errors->first('username')) ? 'error':'',
				Form::block_help($errors->first('username'))
		);	

		echo Form::control_group(
				Form::label('email','E-mail'),
				Form::prepend(Form::text('email', Input::old('email')), '<i class="icon-envelope"></i>'),
				($errors->first('email')) ? 'error':'',
				Form::block_help($errors->first('email'))
		);

		echo Form::control_group(
				Form::label('password','Password'),
				Form::prepend(Form::password('password'), '<i class="icon-key"></i>'),
				($errors->first('password')) ? 'error':'',
				Form::block_help($errors->first('password'))
		);


		echo Form::control_group(
				Form::image(CoolCaptcha\Captcha::img(), 'captcha', array('class' => 'captchaimg')),
				Form::prepend(Form::text('captcha','', array('class' => 'captchainput', 'placeholder' => 'Insert captcha..')),'<i class="icon-hand-left"></i>'),
				($errors->first('captcha')) ? 'error':'',
				Form::block_help($errors->first('captcha'))
		);
	?>		
		<br/>

		{{ Form::submit('Signup', array('class'=>'btn-primary cntr')) }}

		{{ Form::close() }}
	</div>
@endsection