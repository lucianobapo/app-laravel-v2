<table class="table table-hover table-condensed table-bordered">
    <thead>
        <tr>
            <th>{{ trans('modelProduct.attributes.nome') }}</th>
            <th>{{ trans('modelItemOrder.attributes.quantidade') }}</th>
            <th>{{ trans('modelItemOrder.attributes.valor_unitario') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems()->get() as $item)
            <tr>
                <td>{{ $item->product->nome }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>{{ formatBRL($item->valor_unitario) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>