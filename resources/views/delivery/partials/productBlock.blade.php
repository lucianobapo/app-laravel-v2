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
            <del>{{ formatBRL($product->valorUnitVenda) }}</del>
        </div>
        <div>
            {{ formatBRL($product->valorUnitVendaPromocao) }}
        </div>
    @else
        <div>
            {{ formatBRL($product->valorUnitVenda) }}
        </div>
    @endif
</div>