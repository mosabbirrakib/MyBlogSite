@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('response'))
                <div class="alert alert-success">{{session('response')}}</div>
            @endif
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
                                <ul class="nav nav-pills">
                                    <li role="presentation">
                                        <a href="{{url("/like/{$post->id}")}}">
                                            <span class="fa fa-thumbs-up"> LIKE ({{$likesCount}})</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="{{url("/dislike/{$post->id}")}}">
                                            <span class="fa fa-thumbs-down"> DISLIKE ({{$dislikesCount}})</span>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="{{url("/comment/{$post->id}")}}">
                                            <span class="fa fa-comment"> COMMENT</span>
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        @else
                            <p>No Post Available Here !!</p>
                        @endif

                        <form class="" method="post" action="{{route('comment',$post->id)}}">
                            @csrf
                            <div class="form-group">
                                <textarea id="comment" rows="6" class="form-control" name="comment" required autofocus></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg btn-block">POST COMMENT</button>
                            </div>
                        </form>
                        <h3>Comments</h3>
                        @if(count($comments) > 0)
                            @foreach($comments->all() as $comment)
                                <p>{{$comment->comment}}</p>
                                <p><b>Posted By: </b>{{$comment->name}}</p>
                                <hr>
                            @endforeach
                        @else
                            <p>No Comment Here !!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
