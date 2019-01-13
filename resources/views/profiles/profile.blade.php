@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class=" text-center">
            <h2>Welcome, {{ Auth::user()->name }} </h2>
            <p>Your Profile Here..</p>
        </div>
            <!--<div class="pull-right">
                <a class="btn btn-primary" href="{{ url('/category') }}"> Back</a>
            </div>-->
        </div>
    </div>
    {!! Form::open(array('route' => 'profile.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Designation:</strong>
                {!! Form::text('designation', null, array('placeholder' => 'Designation','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Profile Picture:</strong>
                {!! Form::file('image', null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Save Profile</button>
        </div>
    </div>
    {!! Form::close() !!}
    @endsection