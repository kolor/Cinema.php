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

		<h1>Your Profile</h1>
		<p>{{ Typography::muted('This is how other users see you here.') }}</p>
		<hr />
		@if (isset($acc))
			<h3>Personal Information</h3>
		    {{ Image::polaroid($acc['pic'], 'Avatar', array('class'=>'dropzone right', 'title' =>'drag new avatar or click to update')) }}
			
			{{ Typography::horizontal_dl($acc['info']) }}
			<i class="icon-quote-left icon-2x pull-left icon-muted"></i><p class="bio">{{ $acc['bio'] }}</p>
		@else 
			{{ Typography::info(HTML::link('account/edit', 'Please fill in your profile information.')) }}
		@endif
		<hr />

		<h3>Top 10 Favorite Movies</h3>

		{{ Table::striped_open() }}
		{{ Table::headers('#', 'Title', 'Year', 'IMDB') }}
		{{ Table::body($movies_table) }}
		{{ Table::open() }}

	</div>
@endsection

