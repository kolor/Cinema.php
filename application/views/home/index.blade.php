@layout('main')

@section('title')
	Welcome to Cinemator
@endsection

@section('sidebar')
	
@endsection

@section('content')
	<div class="news medium center">
	    @if (count($news) > 0)
    		<h3>{{ $news->title }}</h3>
    		<p>{{ Typography::muted($news->date) }}</p>
    		<p>{{ $news->text }}</p>
    	@else
    	    <h3>No news added yet ;(</h3>
    	    <p>They will surely be added later!</p>
        @endif
	</div>
	<hr/>
@endsection