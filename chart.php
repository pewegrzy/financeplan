<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GrafikChart</title>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui.js" type="text/javascript"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>

</head>
<body>
<div id="inputfields">
    <div id="logo">
        logo
    </div>
    <div id="dateiniput">

        <p> Datum:</p>
        <p>Von: <input type="text" id="fromDate" value="klick" ></p>
        <p>Bis: <input type="text" id="toDate" ></p>
    </div>
    <div id="divrechts">
        <div id="selectorInputGroup">
            Gruppe <select onChange="valGroup()" id="selectorGroup"></select>
            <input id="delete" type="button" value="löschen" onclick="deleteGroup()">
        </div>
        <div id="selectorInputCategory">
           Kategorien <select onChange="val()" id="selector"></select>
            <input id="delete" type="button" value="löschen" onclick="deleteCategory()">
        </div>

        <div id="clear"></div>

        <div id="gruppendiv">
            <div class="header"><span>Neue Gruppe erstellen:</span></div>
            <div id="checkboxInput">
                <p>Neue Gruppe erstellen:</p> <br>
                <input type="text" name="groupName" id="groupName" value="Gruppennamen hier eintragen" onfocus="resetText(this)">
                <input type="button" name="createGroup" id="createGroup" value="Gruppe erstellen" onClick="createGroup()"><br>
            </div>
        </div>
        <div id="categorydiv">
            <div class="header2"><span>Neuen Eintrag erstellen:</span></div>
            <div id="kategoryInput">
                <p>Neuen Eintrag erstellen:</p> <br>
                <input type="text" name="kategorieName" id="kategorieName" value="Kategorienamen hier eintragen" onfocus="resetText(this)">
                <input type="number" name="kategorieAmount" id="kategorieAmount" value="Kosten eintragen" onfocus="resetText(this)">
                <input type="text" name="kategorieDatum" id="kategorieDatum" value="Datum">
                <input type="button" name="createKategore" id="createKategore" value="Eintrag" onClick="createCategory()"><br>
            </div>
        </div>
    </div>

</div>
<div id="strich"></div>
<div id="clear"></div>
<div id="categoriesToGroup"></div>


    <?php
    include 'overview.php';
    ?>

<div id="container" style="width:1200px; height:600px;">

</div>
</body>
</html>