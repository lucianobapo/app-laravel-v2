<!-- Title Form Input -->
<div class="form-group {{ $errors->has('title') ? 'has-error has-feedback':'' }}">
    {!! Form::label('title', trans('article.attributes.title').':') !!}
    {!! Form::text('title',null,['class'=>'form-control']) !!}
    {!! $errors->first('title', '<span class="glyphicon glyphicon-remove form-control-feedback"></span>') !!}
</div>

<!-- Body Form Input -->
<div class="form-group {{ $errors->has('body') ? 'has-error has-feedback':'' }}">
    {!! Form::label('body', trans('article.attributes.body').':') !!}
    {!! Form::textarea('body',null,['class'=>'form-control']) !!}
    {!! $errors->first('body', '<span class="glyphicon glyphicon-remove form-control-feedback"></span>') !!}
</div>

<!-- Published_at Form Input -->
<div class="form-group">
    {!! Form::label('published_at', trans('article.attributes.published_at').':') !!}
    {!! Form::input('date','published_at',$article->published_at,['class'=>'form-control']) !!}
</div>

<!-- Tags Form Input -->
<div class="form-group">
    {!! Form::label('tag_list','Tags:') !!}
    {!! Form::select('tag_list[]', $tags, null, ['id' => 'tag_list', 'class'=>'form-control','multiple']) !!}
</div>

<!-- Add Article Form Input -->
<div class="form-group">
    {!! Form::submit($submitButtonText,['class'=>'btn btn-primary form-control']) !!}
</div>

@section('footer')
    <script>
        $('#tag_list').select2({
            placeholder: 'Choose a Tag',
            tags: true
        });
    </script>
@endsection
@section('headScriptCss')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/css/select2.min.css" rel="stylesheet" />
@endsection
@section('footerScriptJs')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.2/js/select2.min.js"></script>
@endsection