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

		<h1>{{ ucwords($account['info']['Real Name']) }}</h1>
		<p>{{ Typography::muted('This is how other users see you here.') }}</p>
		<hr />
		@if (isset($account))
			<h3>Personal Information</h3>
		    {{ Image::polaroid($account['pic'], 'Avatar', array('class'=>'dropzone right', 'title' =>'drag new avatar or click to update')) }}
			
			{{ Typography::horizontal_dl($account['info']) }}
			<i class="icon-quote-left icon-2x pull-left icon-muted"></i><p class="bio">{{ $account['bio'] }}</p>
		@else 
			<h3>User has not updated his profile yet ;(</h3>
		@endif
		<hr />

		<h3>Top 10 Favorite Movies</h3>

		{{ Table::striped_open() }}
		{{ Table::headers('#', 'Title', 'Year', 'IMDB') }}
		{{ Table::body($movies_table) }}
		{{ Table::open() }}

	</div>
@endsection

