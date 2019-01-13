@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>VIEW POST</strong></div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-group">
                            @if(count($categories) > 0)
                                @foreach($categories->all() as $category)
                                    <li class="list-group-item">
                                        <a href="{{url("category/{$category->id}")}}">{{$category->category}}</a>
                                    </li>
                                @endforeach
                            @else
                                <p>No category Found !!</p>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-8 text-center">
                        @if(count($posts) > 0)
                            @foreach($posts->all() as $post)
                                <h4 style="color: black;">{{$post->title}}</h4>
                                <img src="{{$post->image}}" alt="" width="50%">
                                <p style="text-align: justify; color: black;">{{$post->description}}</p>
                            @endforeach
                        @else
                            <p>No Post Available Here !!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
