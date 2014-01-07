<html>
<head> <title>GrafikChart</title>

</head>
<body>
<script>
    var current_host = document.location.hostname;
    if(document.location.hostname == 'localhost')
        current_host = 'http://'+current_host+'/financeplan/';
    else current_host = 'http://'+current_host+'/';


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
    $(function() {
        $("#kategorieDatum").datepicker({dateFormat: "yy-mm-dd"}).val();
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

    var myCategoryDatum;
    var from = $('#kategorieDatum').change(
        function() {
            var dateString = $('#kategorieDatum').datepicker('getDate');
            if(dateString != null){
                myToDatum = $.datepicker.formatDate('yy-mm-dd', dateString);
                myToDatum = myToDatum+'%2000:00:00'
            }
        }
    ).change();
    //Dropdown erstellen für Kategorie
    var select = document.getElementById("selector");
    var option = document.createElement("option");
    option.value = 0;
    option.textContent = 'Alles';
    select.appendChild(option);
    //http://localhost/financeplan/finance-plan/index.php/getOverallGroupByDate/2013-11-19%2004:22:13/2013-11-30%2004:22:13
    function drawSelectorCategories() {
        var JSON = $.getJSON(current_host+'finance-plan/index.php/showCategories', function(data) {
            var JsonObejct = data['categories'];
            $.each(JsonObejct, function(key, value) {
                var option = document.createElement("option");
                option.value = [key];
                option.textContent = value['Category'];
                select.appendChild(option);
            });
        });
    };

    //Dropdown erstellen für Gruppen
    var selectGroup = document.getElementById("selectorGroup");
    var optionGroup = document.createElement("option");
    optionGroup.value = 0;
    optionGroup.textContent = 'Alles';
    selectGroup.appendChild(optionGroup);
    //http://localhost/financeplan/finance-plan/index.php/getOverallGroupByDate/2013-11-19%2004:22:13/2013-11-30%2004:22:13
    function drawSelectorGroups() {
        var JSON = $.getJSON(current_host+'finance-plan/index.php/getGroups', function(data) {
            var JsonObejct = data['groups'];
            $.each(JsonObejct, function(key, value) {
                var option = document.createElement("option");
                option.value = [key];
                option.textContent = value['groupname'];
                selectGroup.appendChild(option);
            });
        });
    };

    // Neue Gruppe hinzufügen
    $(".header").click(function () {
        $header = $(this);
        //getting the next element
        $content = $header.next();
        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
        $content.slideToggle(500, function () {
            //execute this after slideToggle is done
            //change text of header based on visibility of content div
            $header.text(function () {
                //change text based on condition
                return $content.is(":visible") ? "Collapse" : "Neue Gruppe erstellen";
            });
        });

    });

    function getUhrzeit() {
        var date = new Date();
        var zeit = date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
        return zeit;
    }

    //Neue Kategorie hinzufügen
    function createCategory() {
        var categoryName = $("#kategorieName").val();
        var categoryAmount = $("#kategorieAmount").val();
        var categoryDate = $("#kategorieDatum").val();
        if(!$.isNumeric(categoryAmount))
            alert("Amount ist keine Zahl");
        else if(categoryName == '')
            alert("Kategoriename nicht ausgefüllt!!")
        if(categoryDate == 'Datum')
            alert("Datum ist nicht ausgeüllt!!");
        else {
            var JSON = $.getJSON(current_host+'finance-plan/index.php/createCategory/'+categoryName+'/'+categoryAmount+'/'+categoryDate+' '+getUhrzeit(), function(data) {
            alert(JSON);
            }).always(function () {
                    alert(window.location.reload());
                });
        }

    }

    // Neue Kategorie hinzufügen
    $(".header2").click(function () {
        $header = $(this);
        //getting the next element
        $content = $header.next();
        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
        $content.slideToggle(500, function () {
            //execute this after slideToggle is done
            //change text of header based on visibility of content div
            $header.text(function () {
                //change text based on condition
                return $content.is(":visible") ? "Collapse" : "Neuen Eintrag erstellen";
            });
        });

    });

    // Kategorien zur ausgewählten Gruppe anzeigen
    function showCategoriesToGroups(group) {
        $("#categoriesToGroup").append('<strong>Kategorien der Gruppe<br> '+ group +'</strong><br><br>');
        var actGroup = group;
        var div = document.getElementById('categoriesToGroup');
        var Json = $.getJSON(current_host+'finance-plan/index.php/getCategoriesToGroup/'+actGroup, function(data) {
            var JsonObejct = data['entries'];
            $.each(JsonObejct, function(key, value) {
                $("#categoriesToGroup").append(value['categoryname']+'<br>');

            })
        });
    };
    //Cheboxen mit Kategorien erstellen
    function createCheckboxes() {
        var JSON = $.getJSON(current_host+'finance-plan/index.php/showCategories', function(data) {
            var JsonObject = data['categories'];
            $.each(JsonObject, function(key, value) {
                var label= document.createElement("label");
                var description = document.createTextNode(value['Category']);
                var checkbox = document.createElement("input");

                checkbox.type = "checkbox";    // make the element a checkbox
                checkbox.name = "groupCheckbox";      // give it a name we can check on the server side
                checkbox.value = value['Category'];         // make its value "pair"

                label.appendChild(checkbox);   // add the box to the element
                label.appendChild(description);// add the description to the element

                // add the label element to your div
                document.getElementById('checkboxInput').appendChild(label);
                document.getElementById('checkboxInput').appendChild(document.createElement("br"));

            });

        });
    };

    //Gruppe löschen
    function deleteGroup(){
        if(valGroup() == 'Alles')
            alert("Die Gruppe ALLES kann nicht gelöscht werden");
        else {
            var JSON = $.getJSON(current_host+'finance-plan/index.php/deleteGroup/'+valGroup(), function(data) {


            }).always(function() {
                    alert(window.location.reload());
                });
        }

    }

    //Kategorie löschen
    function deleteCategory(){
        if(val() == 'Alles')
            alert("Die Kategorie ALLES kann nicht gelöscht werden");
        else {
            var JSON = $.getJSON(current_host+'finance-plan/index.php/deleteCategory/'+val(), function(data) {


            }).always(function() {
                    alert(window.location.reload());
                });
        }

    }
    function resetText(feld) {
        //if(feld.value == "Gruppennamen hier eintragen")
            feld.value = "";
    }
    function createGroup() {
        var groupName = document.getElementById('groupName').value;
        if(groupName == "" || groupName.length < 3 || groupName=="Gruppennamen hier eintragen") {
            alert('Der Gruppenname ist zu kurz oder nicht ausgefüllt!!!');
            return;
        }

        var groupValues = {"groupName":groupName};
        var JsonArray = {"group":groupValues};
        var i = 0;
            //console.log(groupName);
        $('input:checked').each(
            function(index, value) {
                groupValues[i] = value['value'];
                i++;
            });

        var stringd = JSON.stringify(JsonArray);
        var Json = JSON.parse(stringd);
        console.log(stringd);
        console.log(Json);
        sendData(Json);
    }
    //Gruppe in der Datenbank anlegen
    function sendData(data) {
        $.ajax({
            url: current_host+'finance-plan/index.php/createGroup',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: data
        });
           alert('Die Gruppe \"'+data['group']['groupName']+'\" wurde erfolgreich erstellt');
        alert(window.location.reload());

    };



    function val() {
        var zeichen = document.getElementById("selector");
        var zeichen2 = zeichen.options[zeichen.selectedIndex].textContent;
        return zeichen2;
    };

    function valGroup() {
        var zeichen = document.getElementById("selectorGroup");
        var zeichen2 = zeichen.options[zeichen.selectedIndex].textContent;
        return zeichen2;
    };


    function drawGraph() {

        $(function () {

            var from = myFromDatum;
            var to = myToDatum;//'2013-11-22%2004:22:13';

            $.getJSON(current_host+'finance-plan/index.php/getOverallGroupByDate/'+from+'/'+to, function(data) {
                var option = {
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
                            text: 'Ausgaben pro Tag'
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
                var datumArray = new Array(mengeEntries);
                var dataArray = new Array(mengeEntries);
                var summeArray = new Array(mengeEntries);
                var i = 0;
                $.each(entries, function(key, value) {
                    dataArray[i] = Runden2Dezimal(parseFloat(value['ausgaben']));
                    datumArray[i] = value['tag'];
                    summeArray[i] = dataArray[i];
                    if(i > 0)
                        summeArray[i] = Runden2Dezimal(dataArray[i] + summeArray[i-1]);
                    i++;
                });
                option.xAxis.categories = datumArray;
                option.xAxis.data = dataArray;
                option.series[0].name = 'Ausgaben pro Tag ';
                option.series[0].type = 'column';
                if(datumArray != false)
                    option.series[1].name = 'Gesamtausgaben seit '+datumArray[0];
                else
                    option.series[1].name = 'Gesamtausgaben';
                option.series[1].data = summeArray;
                option.series[0].data = dataArray;
                chart = new Highcharts.Chart(option);

            });

        });
    }
    function drawGraphByCategory(value) {
        $(function () {
            var actualSelection = value;
            var from = myFromDatum;
            var to = myToDatum;//'2013-11-22%2004:22:13';

            $.getJSON(current_host+'finance-plan/index.php/getCategoryGroupByDate/'+actualSelection+'/'+from+'/'+to, function(data) {
                var option = {
                    chart: {
                        renderTo: "container",
                        type: 'line'
                    },
                    title: {
                        text: 'Ausgaben für '+actualSelection
                    },
                    xAxis: {
                        categories: ['Alles'],
                        labels: {
                            rotation: -45
                        }
                    },
                    yAxis: [{ //pro einkauf
                        title: {
                            text: 'Ausgaben pro Tag'
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
                var datumArray = new Array(mengeEntries);
                var dataArray = new Array(mengeEntries);
                var summeArray = new Array(mengeEntries);
                var i = 0;
                $.each(entries, function(key, value) {
                    dataArray[i] = Runden2Dezimal(parseFloat(value['amount']));
                    datumArray[i] = value['tag'];
                    summeArray[i] = dataArray[i];
                    if(i > 0)
                        summeArray[i] = Runden2Dezimal(dataArray[i] + summeArray[i-1]);
                    i++;
                });
                option.xAxis.categories = datumArray;
                option.xAxis.data = dataArray;
                option.series[0].name = 'Ausgaben pro Tag ';
                option.series[0].type = 'column';
                if(datumArray != false)
                    option.series[1].name = 'Gesamtausgaben seit '+datumArray[0]+' für '+actualSelection;
                else
                    option.series[1].name = 'Gesamtausgaben';
                option.series[1].data = summeArray;
                option.series[0].data = dataArray;
                chart = new Highcharts.Chart(option);

            });

        });
    }

    function drawGraphByGroup(value) {
        $(function () {
            var actualSelection = value;
            var from = myFromDatum;
            var to = myToDatum;//'2013-11-22%2004:22:13';

            $.getJSON(current_host+'finance-plan/index.php/getGroup/'+actualSelection+'/'+from+'/'+to, function(data) {
                var option = {
                    chart: {
                        renderTo: "container",
                        type: 'line'
                    },
                    title: {
                        text: 'Ausgaben für '+actualSelection
                    },
                    xAxis: {
                        categories: ['Alles'],
                        labels: {
                            rotation: -45
                        }
                    },
                    yAxis: [{ //pro einkauf
                        title: {
                            text: 'Ausgaben pro Tag'
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
                var datumArray = new Array(mengeEntries);
                var dataArray = new Array(mengeEntries);
                var summeArray = new Array(mengeEntries);
                var i = 0;
                $.each(entries, function(key, value) {
                    dataArray[i] = Runden2Dezimal(parseFloat(value['ausgaben']));
                    datumArray[i] = value['tag'];
                    summeArray[i] = dataArray[i];
                    if(i > 0)
                        summeArray[i] = Runden2Dezimal(dataArray[i] + summeArray[i-1]);
                    i++;
                });
                option.xAxis.categories = datumArray;
                option.xAxis.data = dataArray;
                option.series[0].name = 'Ausgaben pro Tag ';
                option.series[0].type = 'column';
                if(datumArray != false)
                    option.series[1].name = 'Gesamtausgaben seit '+datumArray[0]+' für '+actualSelection;
                else
                    option.series[1].name = 'Gesamtausgaben';
                option.series[1].data = summeArray;
                option.series[0].data = dataArray;
                chart = new Highcharts.Chart(option);

            });

        });
    }

    selectGraph();

    $('#selector').change(
        function() {
            selectGraph();
        }
    )
    $('#selectorGroup').change(
        function() {
            $('#categoriesToGroup').empty();
            selectGraph();

        }
    )

    drawSelectorCategories();
    drawSelectorGroups();
    createCheckboxes();
    console.log(current_host);
    //drawGraph();
    $('#fromDate').change(
        function() {
            $('#categoriesToGroup').empty();
            selectGraph();
        });
    $('#toDate').change(
        function() {
            $('#categoriesToGroup').empty();
            selectGraph();
        });
function selectGraph() {
    if(val() == 'Alles' && valGroup() == 'Alles') {
        drawGraph();
    }

    else if(val() != 'Alles') {
        drawGraphByCategory(val());
    }
    else if(valGroup() != 'Alles') {

        drawGraphByGroup(valGroup());
        showCategoriesToGroups(valGroup());
    }

    else alert('fuck');

}

</script>


</body>
</html>