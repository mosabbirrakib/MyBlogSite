@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		@if(session('responses'))
		<div class="alert alert-success">{{session('responses')}}</div>
		@endif
		<div class="pull-left">
			<h2>Category</h2>
		</div>
		<div class="pull-right">
			<a class="btn btn-success" href="{{ url('/categories/create') }}"> Create New Category</a>
		</div>
	</div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
	<p>{{ $message }}</p>
</div>
@endif
<table class="table table-bordered">
	<tr>
		<th>No</th>
		<th>Category</th>
		<th width="280px">Action</th>
	</tr>
	@foreach($categories as $category)
	<tr>
		<td>{{$loop->index+1}}</td>
		<td>{{$category->category}}</td>
		<td>
			<a class="btn btn-info" href="{{ route('category.show',$category->id) }}">Show</a>
			<a class="btn btn-primary" href="{{ route('category.edit',$category->id) }}">Edit</a>
			{!! Form::open(['method' => 'POST','route' => ['category.delete', $category->id],'style'=>'display:inline']) !!}
			{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			{!! Form::close() !!}
		</td>
	</tr>
	@endforeach
</table>
@endsection