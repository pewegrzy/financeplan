<html>
<head> <title>GrafikChart</title>

</head>
<body>
<script>

function Runden2Dezimal(x) {
    Ergebnis = Math.round(x * 100) / 100 ;
    return Ergebnis;
}

    $(function() {
        $("#fromDate").datepicker({dateFormat: "yy-mm-dd"});
    });

    $(function() {
        $("#toDate").datepicker({dateFormat: "yy-mm-dd"}).val();
    });
    var myFromDatum;
    var from = $('#fromDate').change(
        function() {
            var dateString = $('#fromDate').datepicker('getDate');
            if(dateString != null){
                myFromDatum = $.datepicker.formatDate('yy-mm-dd', dateString);
                myFromDatum = myFromDatum+'%2000:00:00'
            }
        }
    ).change();

    var myToDatum;
    var from = $('#toDate').change(
        function() {
            var dateString = $('#toDate').datepicker('getDate');
            if(dateString != null){
                myToDatum = $.datepicker.formatDate('yy-mm-dd', dateString);
                myToDatum = myToDatum+'%2000:00:00'
            }
        }
    ).change();

        //$path = 'http://localhost/financeplan/finance-plan/index.php/getOverall/2013-11-19%2004:22:13/2013-11-22%2004:22:13';
function drawGraph() {

    $(function  () {

        var from = myFromDatum;
        var to = myToDatum;//'2013-11-22%2004:22:13';

        //$.getJSON('http://localhost/financeplan/finance-plan/index.php/'+path, function(data) {
        $.getJSON('http://localhost/financeplan/finance-plan/index.php/getOverall/'+from+'/'+to, function(data) {
            var option2 = {
                chart: {
                    renderTo: "container",
                    type: 'line'
                },
                title: {
                    text: 'Ausgaben'
                },
                xAxis: {
                    categories: ['Alles'],
                    labels: {
                        rotation: -45
                    }
                },
                yAxis: [{ //pro einkauf
                    title: {
                        text: 'Ausgaben pro Einkauf'
                    },
                    labels: {
                        formatter: function() {
                            return this.value + ' €';
                        }
                    }
                }, {// gesamtausgaben
                    title: {
                        text: 'Gesamtausgaben'
                    },
                    labels: {
                        formatter: function() {
                            return this.value + ' €';
                            }
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                series: [{
                    tooltip: {
                        valueSuffix: ' €'
                    }
                }, {
                    type: 'spline',
                    yAxis: 1,
                    tooltip: {
                        valueSuffix: ' €'
                    }
                }]
            };
            var entries = (data['entries']);
            var mengeEntries = data['entries'].length;
            var entryArray = new Array(mengeEntries);
            var datumArray = new Array(mengeEntries);

            var i = 0;
            var summeArray = new Array(mengeEntries);
            $.each(entries, function(key, value){
                entryArray[i] = parseFloat(value['amount'] );
                datumArray[i] = value['datum'].substring(0,10)+' - '+value['Category'];
                summeArray[i] = entryArray[i];
                if(i > 0)
                    summeArray[i] = Runden2Dezimal(entryArray[i] + summeArray[i-1]);
                i++;
            } );
            console.log(summeArray);
            option2.xAxis.categories = datumArray;
            option2.xAxis.data = entryArray;
            option2.series[0].name = 'Ausgaben pro Einkauf ';
            if(datumArray != false)
                option2.series[1].name = 'Gesamtausgaben seit '+datumArray[0].substring(0,10);
            else
                option2.series[1].name = 'Gesamtausgaben';
            option2.series[1].data = summeArray;
            option2.series[0].data = entryArray;
            chart = new Highcharts.Chart(option2);

        });

    });
}

drawGraph();
$('#fromDate').change(
    function() {
        drawGraph();
    });
$('#toDate').change(
    function() {
        drawGraph();
});

</script>


</body>
</html>