<div class="" style="padding: 5px;">
    {!! Html::image(config('filesystems.imageUrl').$product->imagem,
    trans('delivery.productBlock.imageAlt', ['product' => $product->nome]),
    ['title'=>trans('delivery.productBlock.imageAlt', ['product' => $product->nome]),
    'class'=>'img-responsive center-block']) !!}
</div>
<div style="padding: 5px;">
    <div>
        {{ $product->nome }}
    </div>
    @if($product->promocao)
        <div>
            <del>{{ $currency->convert($product->valorUnitVenda)->from('BRL')->format() }}</del>
        </div>
        <div>
            {{ $currency->convert($product->valorUnitVendaPromocao)->from('BRL')->format() }}
        </div>
    @else
        <div>
            {{ $currency->convert($product->valorUnitVenda)->from('BRL')->format() }}
        </div>
    @endif
</div>