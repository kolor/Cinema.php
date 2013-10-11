@layout('main')

@section('title')
	Account Recovery
@endsection

@section('sidebar')
	
@endsection

@section('content')

	<div class="half center">
		@if (isset($error))
			{{ Alert::error($error) }}
		@endif
		@if (isset($info))
			{{ Alert::info($info) }}
		@endif

		<h1>Recover Account</h1>
		<p>{{ Typography::muted('Forgot your password? <br/>Provide e-mail address registered with account and follow instructions.') }}</p>
		<hr/>

		{{ Form::inline_open() }}

		{{ Form::prepend(Form::text('email',Input::old('email')), '<i class="icon-envelope"></i>') }}
		{{ Form::submit('Recover', array('class'=>'btn-primary')) }}

		{{ Form::close() }}
	</div>
@endsection