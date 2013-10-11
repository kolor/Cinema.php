@layout('main')

@section('title')
	Private Messages
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

		<h1>Your Inbox</h1>
		<p>{{ Typography::muted('List of conversations with your friends.') }}</p>
		<hr />
		
		<div id="inbox">
			<div class="chat left medium" data-with="0">
				<div class="messages"  data-last="0"></div>
				<textarea class="msg"></textarea>
			</div>
			<div class="friends right short">
				
				@foreach ($friends as $v)
					<div class="person" data-id="{{ $v['id'] }}">
						<img src="http://placehold.it/50x50"> <b>{{ $v['nick'] }}</b> <small>({{ $v['name'] }})</small>
					</div>
				@endforeach
			</div>
		</div>

	</div>
@endsection

