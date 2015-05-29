@extends('app')
@section('content')
    <h1>Edit: {!! $article->title !!}</h1>
    <hr>
    @include ('errors.list')

    {!! Form::model($article, ['method'=>'PATCH','action'=>['ArticlesController@update',$article->id]]) !!}
        @include ('articles.form', ['submitButtonText'=>'Update Article'])
    {!! Form::close() !!}
@endsection