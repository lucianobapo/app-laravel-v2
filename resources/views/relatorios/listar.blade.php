@extends('app')
@section('content')
    <h1>Graphs &amp; Charts - <small>Flot and Sparkline</small></h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                @foreach($scopes as $scope)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ (new OldOrder)->isWbs($scope)?(new OldOrder)->getWbs($scope)[0]->descricao:$scope }} - Delivery 24hs</div>
                        <div class="panel-body">
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class='glyphicon glyphicon-check'></i> Acumulado: Despesas e Receitas - {{ (new OldOrder)->isWbs($scope)?(new OldOrder)->getWbs($scope)[0]->descricao:$scope }}</div>
                                <div class="panel-body">
                                    <div id="{{ $scope }}_acumulado" style="height: 250px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class='glyphicon glyphicon-check'></i> Comparação mensal: Despesas e Receitas - {{ (new OldOrder)->isWbs($scope)?(new OldOrder)->getWbs($scope)[0]->descricao:$scope }}</div>
                                <div class="panel-body">
                                    <div id="{{ $scope }}_comparado" style="height: 250px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class='glyphicon glyphicon-check'></i> Lucro mensal - {{ (new OldOrder)->isWbs($scope)?(new OldOrder)->getWbs($scope)[0]->descricao:$scope }}</div>
                                <div class="panel-body">
                                    <div id="{{ $scope }}_lucro_mensal" style="height: 250px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading"><i class='glyphicon glyphicon-check'></i> Lucro diário e média dos últimos 30 dias - {{ (new OldOrder)->isWbs($scope)?(new OldOrder)->getWbs($scope)[0]->descricao:$scope }}</div>
                                <div class="panel-body">
                                    <div id="{{ $scope }}_lucro_diario" style="height: 250px;width:100%;margin-top:15px; margin-bottom:15px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@stop

@section('footerScriptJs')

    <script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.stack.min.js"></script>--}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.min.js"></script>
    @foreach($scopes as $scope)
        @include('relatorios.partials.flotScript', ['scope'=>$scope])
    @endforeach
@stop