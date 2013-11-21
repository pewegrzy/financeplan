<!DOCTYPE html>
<html>
<head>
    <title>GrafikChart</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<script>
/*
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Fruit Consumption'
            },
            xAxis: {
                categories: ['Apples', 'Bananas', 'Oranges']
            },
            yAxis: {
                title: {
                    text: 'Fruit eaten'
                }
            },
            series: [{
                name: 'Jane',
                data: [1, 0, 4]
            }, {
                name: 'John',
                data: [5, 7, 3]
            }]
        });
    });
*/
/*
    $(document).ready(function() {

        var options = {
            chart: {
                renderTo: 'container',
                type: 'bar'
            },
            series: [{}]
        };

        $.getJSON('data.json', function(data) {
            options.series[0].data = data;
            var chart = new Highcharts.Chart(options);
        });

    });
    */
<?php
    $zahlphp = 8;
?>
$(function () {
    var zahl = <?= $zahlphp ?>;
    $.getJSON('http://localhost/financeplan/finance-plan/index.php/showCategories', function(data) {
        var options = {
            chart: {
                renderTo: "container",
                type: 'bar'
            },
            title: {
                text: 'Ausgaben Januar'
            },
            xAxis: {
                categories: ['apfle', 'banane']
            },
            yAxis: {
                title: {
                    text: 'Ausgaben in Euro'
                }
            },
            series: [{
            name: 'User 1',
            data: [30, 45, 20]
        }, {
            name: 'User 2',
            data: [15, 50, 30, 5, 40, 50]
        }]
        };

        var option2 = {
            chart: {
                renderTo: "container",
                type: 'line'
            },
            title: {
                text: 'Ausgaben Penis'
            },
            xAxis: {
                categories: ['apfle', 'banane']
            },
            yAxis: {
                title: {
                    text: 'Ausgaben in Euro'
                }
            },
            series: [{
                name: 'User 1',
                data: [30, 45, 20]
            }, {
                name: 'User 2',
                data: [15, 50, 30, 5, 40, 50]
            }]
        };
        var kategorien = data['categories'];
        var mengeCategroy = data['categories'].length;
        var cats = new Array(mengeCategroy);
        var i = 0;
        $.each(kategorien, function(key, value){
            //console.log(data['categories']);
            //console.log(value['Category']);
            cats[i] = value['Category'];
            i++;
            console.log(cats);

            console.log(zahl);
        });
        //options.xAxis.categories = data['categories'];
        options.xAxis.categories = cats;

        switch (zahl){
            case 5:
                chart = new Highcharts.Chart(options);
            break;
            case 8:
                chart = new Highcharts.Chart(option2);
                break;
        }

    });

});

</script>

<div id="container" style="width:1200px; height:600px;">


</div>
</body>
</html>