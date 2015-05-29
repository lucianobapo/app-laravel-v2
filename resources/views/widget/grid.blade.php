    @if(count($lines)>0)
        {!! Form::model($sharedCurrency = new SharedCurrency, ['url'=>'sharedCurrencies']) !!}
        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                @foreach($columns as $column)
                    <th>{!! link_to_route_sort_by($route, $column, trans($translation['attributes'].'.'.$column), $getParams) !!}</th>
                @endforeach
                <th>{{ trans('widget.grid.actions') }}</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($columns as $column)
                        <td>{!! Form::text($column,null,['class'=>'form-control']) !!}</td>
                    @endforeach
                </tr>
            @foreach($lines as $line)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $line->$column }}</td>
                    @endforeach
                    <td> </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! Form::close() !!}
        {!! $lines->render() !!}
    @else
        <em>{{ trans($translation['noResoults']) }}</em>
    @endif