{!! Form::model($products, ['url'=>route('delivery.addCart', $host), 'id'=>'form-add-setting']) !!}
<div style="list-style-type: none; padding: 0px;">
    @foreach($products as $product)
        <div class="col-sm-2 well" style="min-width: 200px; float: none; display: inline-block; vertical-align: top; padding: 0px; margin: 0px 5px 10px;">
            @include('delivery.partials.productBlock')
            <div class="row" style="margin: 0px;">
                @include('delivery.partials.productBlockForm')
            </div>
        </div>
    @endforeach
</div>
{!! Form::close() !!}