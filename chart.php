<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GrafikChart</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>

    <!-- <link type="text/css" rel="stylesheet" href="calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen">
    <SCRIPT type="text/javascript" src="calendar/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script> -->

</head>
<body>

<div id="userInput">
    <a href="chart.php?site=overview">overview</a>
    <a href="chart.php?site=overviewCategories">categories</a>
    <a href="chart.php?site=group">groups</a>
</div>


<div id="dateiniput">
    <p>Date: <input type="text" id="fromDate"></p>
    <p>Date: <input type="text" id="toDate"></p>
</div>





<!-- <form>
    <table>

        <tr><td>Ausgaben von: </td><td><td><input type="text" value="25.11.2013" name="theFromDate" id="theFromDate"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theFromDate,'dd.mm.yyyy',this)"></td></tr>
        <tr><td>Ausgaben bis: </td><td><td><input type="text" value="25.11.2013" name="theToDate" id="theToDate"><input type="button" value="Cal" onclick="displayCalendar(document.forms[0].theToDate,'dd.mm.yyyy',this)"></td></tr>

    </table>
-->
    <?php

    if (isset($_GET["site"]))
    {
        $site = $_GET["site"];
        if (strlen($site) != 0)
        {
            if ($site == "overview")
                include 'overview.php';

            if ($site == "overviewCategories")
                include 'overviewCategories.php';

            if ($site == "group")
                include 'group.php';
        }
    }
    ?>

<div id="container" style="width:1200px; height:600px;">


</div>
</body>
</html>