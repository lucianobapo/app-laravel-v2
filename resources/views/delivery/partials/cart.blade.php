<table class="table" id="cartTable">
    {{--<thead>--}}
        {{--<tr>--}}
            {{--<th></th>--}}
        {{--</tr>--}}
    {{--</thead>--}}
    <tbody>
        @foreach($cart as $row)
            <tr>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['qty'] }}</td>
                <td>{{ $currency->convert($row['price'])->from('BRL')->format() }}</td>
                <td>{{ $currency->convert($row['subtotal'])->from('BRL')->format() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="">

    {{ trans('delivery.nav.cartTotal') }}: {{ $currency->convert(Cart::total())->from('BRL')->format() }}
</div>
<div class="">
    {!! isset($host)? link_to_route('delivery.pedido', trans('delivery.nav.cartBtn'), $host, ['class'=>'btn btn-success']):false !!}
</div>