@layout('main')

@section('title')
	Welcome to Cinemator
@endsection

@section('sidebar')
	
@endsection

@section('content')
	<div class="news medium center">
		<h3>{{ $news->title }}</h3>
		<p>{{ Typography::muted($news->date) }}</p>
		<p>{{ $news->body }}</p>
	</div>
	<hr/>
@endsection