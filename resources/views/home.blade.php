@extends('layouts.app')
<style type="text/css">
.avatar{
    border-radius: 100%;
    max-width: 50%;
}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
            @if(session('response'))
            <div class="alert alert-success">{{session('response')}}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4"><strong>VIEW ALL POST</strong></div>
                        <div class="col-md-4">
                            <form action="{{url('/search')}}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search...">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-danger">
                                            Go!
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-md-4">
                        @if(!empty($profiles))
                        <img src="{{$profiles->image}}" class="avatar" alt="{{$profiles->name}}">
                        @else
                        <img src="{{url('/images/avatar.png')}}" class="avatar" alt="">
                        @endif
                        @if(!empty($profiles))
                        <p><strong>{{$profiles->name}}</strong></p>
                        @else
                        <p></p>
                        @endif
                        @if(!empty($profiles))
                        <p>{{$profiles->designation}}</p>
                        @else
                        <p></p>
                        @endif                        
                    </div>
                    <div class="col-md-8 text-center">
                        @if(count($posts) > 0)
                        @foreach($posts->all() as $post)
                        <h4 style="color: black;">{{$post->title}}</h4>
                        <img src="{{$post->image}}" alt="" width="50%">
                        <p style="text-align: justify; color: black;">{{substr($post->description, 0, 150)}}</p>
                        <ul class="nav nav-pills">
                            <li role="presentation">
                                <a href="{{route('postCRUD2.view',$post->id)}}">
                                    <span class="fa fa-eye"> VIEW</span>
                                </a>
                            </li>
                            @if(Auth::user()->id == 1)
                            <li role="presentation">
                                <a href="{{ route('postCRUD2.edit',$post->id) }}">
                                    <span class="fa fa-pencil-square-o"> EDIT</span>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="{{ route('postCRUD2.destroy',$post->id) }}">
                                    <span class="fa fa-trash"> DELETE</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        <cite style="float: left;"><b>Posted on: </b>{{date('M j Y H:i', strtotime($post->updated_at))}}</cite>
                        <hr>
                        @endforeach
                        @else
                        <p>No Post Available Here !!</p>
                        @endif
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
