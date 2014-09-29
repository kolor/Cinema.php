@layout('main')

@section('title')
	Friends List
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

		<h1>Your Friends</h1>
		<p>{{ Typography::muted('Your list of friends.') }}</p>
		<hr />
		
		<div id="friends">
			@foreach ($friends as $v)
				<div class="person" data-id="{{ $v['id'] }}">
					<img src="{{ $v['avatar'] }}"><br/> <b>{{ $v['full_name'] }}</b> <small>({{ $v['username'] }})</small>
				</div>
			@endforeach
		</div>

	</div>
@endsection
