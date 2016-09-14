<?php

//require 'controlpanelback.php';

print_r($_POST);
print_r($_GET);
/*
//init vars
$inFName = "";
$sql = "";

if( isset($_GET['pidToDelete'])) {
    // sql to delete a record 
    $sql = "DELETE FROM ProductTable WHERE id=".$_GET['pidToDelete'];
     
    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully"; // REPLACE WITH BOOTSTRAP ALERT
    } else {
      echo "Error deleting record: " . $conn->error; // rePLACE WITH BOOTSTRAP ALERT
    }
}

// open input csv file
if (isset($_POST['inFile']) && strlen($_POST['inFile']) != 0 )
{
    $inFName = $_POST["inFile"];
} else {
    $inFName = "products.csv";
}

//<!--write data from db to csv-->
$sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable";
$result = $connection->query($sql);

if( isset($_POST['dbToCSV']) && strlen($_POST['CSVoutFile'])!= 0 && $result->num_rows > 0 ){
    $outFName = $_POST['CSVoutFile'];
    $list = array(
        array('id', 'name','descrip', 'quantity', 'price', 'descID')
    );
    while($row = $result->fetch_assoc()) {

        $list[] = array($row["id"], $row["name"] , $row["descrip"] ,
        $row["quantity"] ,  $row["price"] , $row["descID"]);

    }

    //reset for next fetch_assoc()
    $result->data_seek(0);
    
    if (($outHandle = @fopen($outFName, "w")) !== FALSE) {
        foreach ($list as $line)
        {
            fputcsv($outHandle,$line);
        }
        fclose($outHandle);
    }else{
        //output cannot open file, write to csv failed
    }
    //$list->free_result();
} 
*/

?>

<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript">
// DO ALL BUTTON JQUERY/JS ACTIONS HERE
$(document).ready(function(){
    
    $("#dbToCSVButton").mouseup( 
        function () { 
            alert("dbToCSV!!");
            //exportDB(document.getElementById('dbToCSVfname').value) } 
        });
        /*function(){
        $(this).after("<p style='color:green;'>Mouse button released.</p>");

    });*/

    $("#CSVtoDBButton").mouseup( 
        function () { 
            alert("CSVtoDB!!");
            //importCSV() } 
        });
    $("#CSVButton").click( 
        function () { 
            alert("CSV!!");
            //refreshCSV(document.getElementById('CSVfname').value) 
        });
    $("#DaButton").click(
        function() {
            $.get("controlpanelback.php",{d: 3}, 
            function(data, status) {
                if(status == "success") {
                    
                    var logId = $(data).filter(".log-msg").attr("id");
                    logId = "#" + logId;
                    alert($(data).filter(".log-msg") + "logId: "+ logId);
                    $("#logBox").prepend( $(data).filter(".log-msg").addClass('hidden') ); 
                    $(logId).hide();
                    $(logId).removeClass('hidden');
                    $(logId).show(1000);
                } else {
                    alert("Something went wrong when loading!\nStatus: "+status);
                }

            });
        });



});


function refreshCSV(fn) {
    var response = confirm("Are you sure you want to load " +fn+" ?");
     if (response == true) {
        //confirm, refresh CSV Table using jquery AJAX
        $.get("controlpanelback.php",{d: 2, CSVfname: fn}, 
            function(data, status) {
                if(status == "success") {
                    $("#logBox").prepend( $(data).filter("#logEvent") ); 
                    $("#CSVTable").html( $(data).filter("CSVTable") );
                } else {
                    alert("Something went wrong when loading "+fn+" !\nStatus: "+status);
                }

            });
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
                    $("#CSVTable").html( $(data).filter("CSVTable") );
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

function importCSV() {
    var response = confirm("Are you sure you want to import current CSV to DB?");
    if(response == true) {
        //confirmed start XMLHTTP Request
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

<?php
/*
if ($result->num_rows > 0) {
    echo
        "
        <h1>Product Table</h1>
        <table class=\"table table-striped\">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>CateID</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        echo
            "<tr";
        if( $row['quantity'] == 0 ) 
            echo " class=\"danger\"";
        echo ">
            <td>".$row['id']."</td>
            <td>".$row['name']."</td>
            <td>".$row['descrip']."</td>
            <td>".$row['quantity']."</td>
            <td>".$row['price']."</td>
            <td>".$row['descID']."</td>
            <td>
            <form action=\"".htmlspecialchars($_SERVER['PHP_SELF'])."\" method=\"get\">
            <input type=\"hidden\" name=\"pidToDelete\" value=".$row['id'].">
            <input type=\"hidden\" name=\"pName\" value=\"".$row['name']."\">
            <input type=\"submit\" value=\"X\"></form>      
            </td>
            </tr>";
    }
    echo "</tbody></table>";
    $result->free_result();
} else {
    echo "0 results";
}
 */

?>
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

<div class="col-xs-6 text-center"> 
<div id="CSVTable">
<?php
/*
if (($inHandle = @fopen($inFName, "r")) !== FALSE) {
    //read header row
    //fgetcsv($handle,600);
    echo
        "<h1> $inFName </h1>
        <table class=\"table table-striped\">
        <thead>
        <tr>";
    $data = fgetcsv($inHandle,600);
    //print header + use for loop?
    echo "<th>$data[0]</th>";
    echo "<th>$data[1]</th>";
    echo "<th>$data[2]</th>";
    echo "<th>$data[3]</th>";
    echo "<th>$data[4]</th>";
    echo "</tr>
        </thead>
        <tbody>";

    while (($data = fgetcsv($inHandle, 600)) !== FALSE) {
       echo
            "<tr>
            <td>".$data[0]."</td>
            <td>".$data[1]."</td>
            <td>".$data[2]."</td>
            <td>".$data[3]."</td>
            <td>".$data[4]."</td>
            </tr>";
    }
    echo "</tbody></table>";

    
    fclose($inHandle);
}else{
    //file did not open
    echo "<br>Error opening $inFName<br>";
}
*/
?>
</div>
<!--button: retrieve non-default file-->
<br>
<div id="CSVTableForms">
<form>
<strong>Load CSV file</strong><br>
<label for="CSVfname">Filename:</label>
<input type="text" id="CSVfname">
<input type="button" value="Load" id="CSVButton">
</form>
<br>

<form>
<strong>Import current/opened CSV to DB </strong><br>
<label for="CSVtoDBfname">Filename:</label>
<input type="text" id="CSVtoDBfname">
<input type="button" value="Import" id="CSVtoDBButton">
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


