@extends('app')
@section('content')
    <h1 class="h1s">{{ trans('order.title') }}</h1>
    <hr>
    @if(count($orders))
        <table class="table table-hover">
            <thead>
            <tr>
                <th>{{ trans('modelOrder.attributes.id') }}</th>
                <th>{{ trans('modelPartner.attributes.nome') }}</th>
                <th>{{ trans('modelOrder.attributes.valor_total') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->partner->nome }}</td>
                    <td>{{ formatBRL($order->valor_total) }}</td>
                </tr>
                @if(count($order->orderItems))
                    <tr>
                        <td class="text-right">{{ trans('order.listaItens').':' }}</td>
                        <td colspan="2">
                            @include('orders.partials.itemOrder', compact('order'))
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @else
        <div>
            <em>{{ trans('order.empty') }}</em>
        </div>
    @endif

@endsection