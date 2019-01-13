@extends('layouts.app')
 
@section('content')
	<div class="row">
	    <div class="col-lg-12 margin-tb">
	        <div class="pull-left">
	            <h2>Create New Category</h2>
	        </div>
	        <div class="pull-right">
	            <a class="btn btn-primary" href="{{ url('/category') }}"> Back</a>
	        </div>
	    </div>
	</div>
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@if(session('responses'))
		<div class="alert alert-success">{{session('responses')}}</div>
	@endif
	{!! Form::model($category, ['method' => 'POST','route' => ['category.update', $category->id]]) !!}
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Category:</strong>
                <input type="text" class="form-control" name="category" value="{{$category->category}}">
                <!--{!! Form::text('category', null, array('$category' => 'category','class' => 'form-control')) !!} -->
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
				<button type="submit" class="btn btn-primary">Update Category</button>
        </div>
	</div>
	{!! Form::close() !!}
@endsection