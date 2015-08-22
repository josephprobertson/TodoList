@extends('layouts.main')
@section('content')
	<div class="large-12 columns">
		<h2>{{{ $list->name }}}</h2>
		<p>{!! link_to_route('todos.index', 'back') !!}</p>
		@foreach ($items as $item)
			<h4>{!! $item->content !!}</h4>
		@endforeach
	</div>
@stop