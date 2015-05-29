@extends('app')
@section('content')
    <h1>{{ trans('sharedCurrencies.index.title') }}</h1>
    <hr>
    @include(
        'widget.grid',
        array (
            'lines' => $sharedCurrencies,
            'route' => 'sharedCurrencies.index',
            'getParams' => $params,
            'translation' => [
                'noResoults' => 'sharedCurrencies.index.noResoults',
                'attributes' => 'sharedCurrencies.attributes'],
            'columns' => [
                'nome_universal',
                'descricao']
        )
    )
@stop