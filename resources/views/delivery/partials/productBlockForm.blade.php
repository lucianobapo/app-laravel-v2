<div class="form-group col-sm-6" style="padding: 5px;">
    {!! Form::input('hidden','valor['.$product->id.']', ($product->promocao?$product->valorUnitVendaPromocao:$product->valorUnitVenda), ['class'=>'pass']) !!}
    {!! Form::input('hidden','nome['.$product->id.']', $product->nome, ['class'=>'pass']) !!}
    {!! Form::input('number','quantidade['.$product->id.']', 0, [
        'class'=>'form-control pass tooltiped',
        'min'=>0,
        'max'=>3
    ]) !!}

</div>
<div class="form-group col-sm-6" style="padding: 5px;">
    {!! Form::submit(trans('delivery.productBlock.formAddButton'),[
        'class'=>'btn btn-primary form-control'
    ]) !!}
</div>