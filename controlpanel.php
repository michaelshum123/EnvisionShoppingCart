<?php

//require 'controlpanelback.php';
require 'connect.php';
print_r($_POST);
print_r($_GET);

//TODO: ADD INDIVIDUAL DB ADD, DB EDIT+SAVE
?>

<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">

window.msgid = 0;

// DO ALL BUTTON JQUERY/JS ACTIONS HERE
$(document).ready(function(){

    showProductTable();
    showCSVTable("", false);
    $("#dbToCSVButton").mouseup( 
        function () { 
            alert("dbToCSV!!");
            //exportDB(document.getElementById('dbToCSVfname').value) } 
        });


    $("#CSVtoDBButton").mouseup( 
        function () { 
            // pass through h1 elem of CSVTable, aka filename
            if( document.getElementById("owRB").checked || document.getElementById("skipRB").checked ) {
                alert($("#CSVTable > h1").text() + " radio:" + document.getElementById("skipRB").checked);
                importCSV( $("#CSVTable > h1").text(), document.getElementById("skipRB").checked);
            } else {
                alert("radioboxes are broken!");
            }
        });
    $("#CSVButton").mouseup( 
        function () { 
            //alert("CSV!!");
            refreshCSV( document.getElementById('CSVfname').value, true); 
        });
    $("#DaButton").mouseup(
        function() {
            $.get("controlpanelback.php",{d: 3}, 
            function(data, status) {
                if(status == "success") {
                    addLogMsg(data);
                } else {
                    alert("Something went wrong when loading back!\nStatus: "+status);
                }

            });
            
        });



});

//adds a log msg, sets unique id, and makes it fade in lol
function addLogMsg(data) {
//add unique val to id
    var logId = "logMsg" + window.msgid.toString();
    //add hidden and set id to unique val  
    var html = $(data).filter(".log-msg").addClass('hidden').prop("id", logId);

    //add to logBox
    $("#logBox").prepend( html ); 
                    //make logId a selector for jquery
    logId = "#" + logId;
                    //hide by logId
    //all this just to fadein
    $(logId).hide();
    $(logId).removeClass('hidden');
    $(logId).show(500);
    window.msgid++;
}

//product table

function showProductTable() {
    $.get("controlpanelback.php",{d: 1}, 
        function(data, status) {
            if(status == "success") {
                $("#productTable").html(data);
            } else {    
                alert("Something went wrong when loading back!\nStatus: "+status);
            }

        });

}

//loads CSV table
//if fn is set, then a logMsg will appear
//if fn is not set, no msg will appear (assumes inital loading)
function showCSVTable(fn, printLog) {
    $.get("controlpanelback.php",{d: 2, 'CSVfname': fn}, 
        function(data, status) {
            if(status == "success") {
                // add return'd CSVTable to this CSVTable
                $("#CSVTable").html( $(data).filter("#CSVTable").html() );
                if(printLog == true) {
                    addLogMsg(data); // if fn is empty aka nothing, load default products.csv
                } 
            } else {    
                alert("Something went wrong when loading back!\nStatus: "+status);
            }

        });
}

function refreshCSV(fn) {
    var response = confirm("Are you sure you want to load " +fn+" ?");
     if (response == true) {
        //confirm, refresh CSV Table using jquery AJAX
        showCSVTable(fn,true);
    }
}

function deleteProduct(pid) {
    var response = confirm("Are you sure you want to delete this item?");
    if (response == true) {
        /* sorry js, jquery is cooler
        //confirm, delete product using XMLHTTP request
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("logBox").innerHTML = this.responseText;
            }
        };

        //send POST
        xhttp.open("POST", "controlpanelback.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("pidToDelete="+pid); 
        */
        $.get("controlpanelback.php", {f: 3, pidToDelete: pid},
            function(data,status) {
                if(status == "success") {
                    $("#logBox").prepend( $(data).filter("#logEvent") ); 
                    $("#CSVTable").html( $(data).filter("#CSVTable") );
                } else {
                    alert("Something went wrong when communicating with backend when deleting\n \
                            Product Name: " + document.getElementById("pNameToDelete").value + "\n \
                            PID: " + pid +"\n \
                            Status: "+status);
                }
            }
         );
    } 
}

function importCSV(fn, dupCheck) {
    var response = confirm("Are you sure you want to import current CSV to DB?");
    if(response == true) {
        //confirmed, start ajax
        alert("filename:" + fn + " dup: " + dupCheck);
        $.get("controlpanelback.php",{f: 1, 'CSVfname': fn, duplicate: dupCheck}, 
            function(data, status) {
                if(status == "success") {
                    alert(data);
                    showProductTable();
                    addLogMsg(data);
                } else {
                    alert("Something went wrong when loading "+fn+" !\nStatus: "+status);
                }

            });
        
    } else {
        //do nothing
    }
}

function exportDB(fn) {
    var response = confirm("Are you sure you want to export DB to " + fn + ".csv?");
    if(response == true) {
        //confirm, start XMLHttp Request

    } else {
        // did not confirm
    }

} 
</script>
</head>

<body>
<div class="container-fluid">
<div class="row">
<div class="col-xs-12" id="logBox">
<!-- put alerts here-->

</div>
</div>
</div>


<div class="container-fluid">
<div class="row">
<div class="col-xs-6 text-center">
<div id="productTable">
<!--
display db table
-->


</div>
<!--button: write data from db to csv for backup-->
<div id="productTableForms">
<form>
<strong>Export Product Table to CSV file</strong>
<br>
<label for="dbToCSVfname">Filename:</label>
<input type="text" id="dbToCSVfname">
<input type="button" value="Export" id="dbToCSVButton">
</form>
</div>

</div>
<!-- divider to make middle of page -->

<div class="col-xs-6"> 
<div id="CSVTable">

</div>

<div id="CSVTableForms">
<form>
<strong>Load CSV file</strong><br>
<small>If the filename entered is empty, the default file 'products.csv' will be loaded</small><br>
<label for="CSVfname">Filename:</label>
<input type="text" id="CSVfname">
<input type="button" value="Load" id="CSVButton">
</form>

<br>

<form>
<strong>Import current/opened CSV to DB </strong><br>

Deal with duplicates by:<br>
<small>
Overwrite will replace items with the same name in the DB with new description, quantity, price, and category from the CSV file
<br>
Skip will simply leave same name items alone, completely skipping them
</small>
<br>
<div class="text-center">
<label class="radio-inline"><input type="radio" name="duplicateSetting" id="owRB"> Overwrite </label>

<label class="radio-inline"><input type="radio" name="duplicateSetting" id="skipRB" checked> Skip</label>

<!--<label for="CSVtoDBfname">Filename:</label>
<input type="text" id="CSVtoDBfname">-->
<br>

<input type="button" value="Import" id="CSVtoDBButton">
</div>
</form>
<br>
<form>
<strong>button </strong><br>
<label for="CSVtoDBfname">Filename:</label>
<input type="text" id="CSVtoDBfname">
<input type="button" value="Import" id="DaButton">
</form>
</div>

</div>
</div>
</div>

<div class="container-fluid">
<div class="row">
<div class="text-center col-xs-6">

</div>
</div>
</div>
</body>
</html>


