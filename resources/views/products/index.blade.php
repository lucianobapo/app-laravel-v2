
@extends('app')
@section('content')
    <h1 class="h1s">{{ trans('product.title') }}</h1>
    <hr>
    @include ('errors.list')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('modelProduct.attributes.id') }}</th>
            <th>{{ trans('modelProduct.attributes.nome') }}</th>
            <th>{{ trans('modelProduct.attributes.imagem') }}</th>
            <th>{{ trans('modelProduct.attributes.promocao') }}</th>
            <th>{{ trans('modelProduct.attributes.valorUnitVenda') }}</th>
            <th>{{ trans('modelProduct.attributes.valorUnitVendaPromocao') }}</th>
            <th>{{ trans('modelProduct.attributes.valorUnitCompra') }}</th>
            <th>{{ trans('product.actionTitle') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            {!! Form::open([
                'url'=>route('products.store', $host),
                'files' => true,
            ]) !!}
            <td></td>
            <td>{!! Form::text('nome', null, ['class'=>'form-control', 'required'=>true]) !!}</td>
            <td>{!! Form::file('imagem', ['class'=>'form-control', 'accept'=>'.png']) !!}</td>
            <td>{!! Form::checkbox('promocao', 1, null, ['class'=>'']) !!}</td>
            <td>{!! Form::text('valorUnitVenda', null, ['class'=>'form-control']) !!}</td>
            <td>{!! Form::text('valorUnitVendaPromocao', null, ['class'=>'form-control']) !!}</td>
            <td>{!! Form::text('valorUnitCompra', null, ['class'=>'form-control']) !!}</td>
            <td>{!! Form::submit(trans('product.actionBtn'), ['class'=>'form-control btn btn-primary']) !!}</td>
            {!! Form::close() !!}
        </tr>
        @if(count($products))
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->nome }}</td>
                    <td>{{ $product->imagem }}</td>
                    <td>{{ trans('modelProduct.values.promocao.'.$product->promocao) }}</td>
                    <td>{{ formatBRL($product->valorUnitVenda) }}</td>
                    <td>{{ formatBRL($product->valorUnitVendaPromocao) }}</td>
                    <td>{{ formatBRL($product->valorUnitCompra) }}</td>
                    <td>{!! sprintf( link_to_route('products.destroy', '%s', [$host,$product->id], ['title'=>trans('product.actionDeleteTitle')]), '<span class="glyphicon glyphicon-remove"></span>' ) !!}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center"><em>{{ trans('product.empty') }}</em></td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection