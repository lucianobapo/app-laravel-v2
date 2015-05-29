<script type="text/javascript">
var d1 = [ {{ $receitas[$scope.'_acumulado'] }} ];
var d2 = [ {{ $despesas[$scope.'_acumulado'] }} ];

$.plot("#{{ $scope }}_acumulado", [
    { label: "Despesas", data: d2,color: "#AA4643" },
    { label: "Receitas", data: d1,color: "#89A54E" }

    //{ label: "tan(x)", data: d3 }
], {
    series: {
        lines: { show: true },
        points: { show: true }
    },

    xaxis: {
        min: {{ strtotime('-1 month',$primeira_data)*1000 }},
        max: (new Date()).getTime(),
        mode: "time",
        timeformat: "%b/%Y",
        tickSize: [1, "month"],
        //monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        //tickLength: 0, // hide gridlines
        axisLabel: 'Month'/*,
         axisLabelUseCanvas: true,
         axisLabelFontSizePixels: 12,
         axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
         //axisLabelPadding: 5*/
    },

    legend: {
        position: "ne",
        margin: [0,-25],
        noColumns: 0,
        labelBoxBorderColor: null,
        labelFormatter: function(label, series) {
            // just add some space to labes
            return label+'&nbsp;&nbsp;';
        }
    },
    grid: {
        backgroundColor: { colors: [ "#fff", "#eee" ] },
        borderWidth: {
            top: 1,
            right: 1,
            bottom: 2,
            left: 2
        }
    }
});


var d1 = [ {{ $receitas[$scope.'_comparado'] }} ];
var d2 = [ {{ $despesas[$scope.'_comparado'] }} ];
var data1 = [

    {
        label: "Despesas",
        data: d2,
        stack: false,
        //align: 'center',
        bars: {
            show: true,
            align: "right",
            //barWidth: 1/4,
            barWidth: 12*24*60*60*300,

            fill: true,
            lineWidth: 1,
            //order: 2,
            fillColor:  "#AA4643"
        },
        color: "#AA4643"
    },

    {
        label: "Receitas",
        data: d1,
        stack: false,
        bars: {
            show: true,
            align: "left",
            //barWidth: 1/4,
            barWidth: 12*24*60*60*300,

            fill: true,
            lineWidth: 1,
            //order: 1,
            fillColor:  "#89A54E"
        },
        color: "#89A54E"
    }

];

var options = {
    /**/
    xaxis: {
        min: {{ strtotime('-1 month',$primeira_data)*1000 }},
        max: (new Date()).getTime(),
        mode: "time",
        timeformat: "%b/%Y",
        tickSize: [1, "month"],
    },

    grid: {
        hoverable: true,
        clickable: false,
        borderWidth: 1
    },
    legend: {
        position: "ne",
        margin: [0,-25],
        noColumns: 0,
        labelBoxBorderColor: null,
        labelFormatter: function(label, series) {
            // just add some space to labes
            return label+'&nbsp;&nbsp;';
        }
    },
    series: {
        shadowSize: 1
    }
};

$.plot("#{{ $scope }}_comparado", data1,options);


    //var data = [ ["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9] ];
    var data = [ {{ $lucro[$scope] }} ];
    $.plot("#{{ $scope }}_lucro_mensal", [ data ], {
        series: {
            bars: {
                show: true,
                barWidth: 12*24*60*60*300,
                align: "center"
            }
        },
        xaxis: {
            min: {{ strtotime('-1 month',$primeira_data)*1000 }},
            max: (new Date()).getTime(),
            mode: "time",
            timeformat: "%b/%Y",
            tickSize: [1, "month"]
        }
    });

    var data = [ {{ $lucroDiario[$scope] }} ];
    var dataMedia = [ {{ $lucroDiario[$scope.'_media'] }} ];
    $.plot("#{{ $scope }}_lucro_diario", [
        {
            data: data,
            label: "Diário",
            bars: {
                show: true,
                barWidth: 1000*60*60*24,
                align: "center"
            }
        },
        {
            data: dataMedia,
            label: "Média ({{ round($lucroDiario[$scope.'_mediaValor']) }})",
            lines: { show: true }
        } ], {

        xaxis: {
            min: {{ strtotime('-2 days',$primeira_data_diario)*1000 }},
            max: (new Date()).getTime(),
            mode: "time",
            timeformat: "%b/%Y",
            tickSize: [1, "month"]
        },
        legend: {
            position: "ne",
            margin: [0, -25],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function (label, series) {
                // just add some space to labes
                return label + '&nbsp;&nbsp;';
            }
        }
    });

</script>