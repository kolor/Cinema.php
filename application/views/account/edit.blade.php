@layout('main')

@section('title')
	Edit Profile
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

		<h1>Edit Profile</h1>
		<p>{{ Typography::muted('Provide additional information about yourself here.') }}</p>
		<hr/>
		
	<?	echo Form::horizontal_open();

		echo Form::control_group(
				Form::label('first_name','First Name'),
				Form::text('first_name', $account->first_name)
		);

		echo Form::control_group(
				Form::label('last_name','Last Name'),
				Form::text('last_name', $account->last_name)
		);

		echo Form::control_group(
				Form::label('country','Country'),
				Form::select('country', $countries)
		);

		echo Form::control_group(
				Form::label('city','City / Town'),
				Form::text('city', $account->city)
		);

		echo Form::control_group(
				Form::label('language','Language'),
				Form::select('language', $languages)
		);

		echo Form::control_group(
				Form::label('dob','Date of Birth'),
				Form::date('dob', $account->dob, array('class'=>'calendar')),
				($errors->first('dob'))?'error':'', Form::block_help($errors->first('dob'))
		);	

		echo Form::control_group(
				Form::label('bio','Biography'),
				Form::textarea('bio', $account->bio, array('rows'=>'4', 'placeholder'=>'Something about yourself..'))
		);
	?>
		<br/>
		{{ Form::submit('Save', array('class'=>'btn-success cntr')) }}

		{{ Form::close() }}
	</div>
@endsection