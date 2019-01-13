@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12 margin-tb">
		<div class="pull-left">
			<h2>Post CRUD</h2>
		</div>
		<div class="pull-right">
			@permission('post-create')
			<a class="btn btn-success" href="{{ route('postCRUD2.create') }}"> Create New Post</a>
			@endpermission
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
		<th>Title</th>
		<th>Description</th>
		<th>Category</th>
		<th>Featured Image</th>
		<th width="280px">Action</th>
	</tr>
	@foreach ($posts as $key => $post)
	<tr>
		<td>{{ ++$i }}</td>
		<td>{{ $post->title }}</td>
		<td>{{ $post->description }}</td>
		<td>{{ $post->category_id }}</td>
		<td>
			@if(!empty($post))
			<img src="{{$post->image}}" class="" alt="" width="30%" height="10%">
			@endif
		</td>
		<td>
			<a class="btn btn-info" href="{{ route('postCRUD2.show',$post->id) }}">Show</a>
			@permission('post-edit')
			<a class="btn btn-primary" href="{{ route('postCRUD2.edit',$post->id) }}">Edit</a>
			@endpermission
			@permission('post-delete')
			{!! Form::open(['method' => 'DELETE','route' => ['postCRUD2.destroy', $post->id],'style'=>'display:inline']) !!}
			{!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			{!! Form::close() !!}
			@endpermission
		</td>
	</tr>
	@endforeach
</table>
{!! $posts->render() !!}
@endsection