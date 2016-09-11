<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname   = "OnlineStoreDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

print_r($_POST);
print_r($_GET);

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
// open csv file
if (isset($_POST['inFile']) && strlen($_POST['inFile']) != 0 )
{
    $inFName = $_POST["inFile"];
} else {
    $inFName = "products.csv";
}

//<!--write data from db to csv-->
$sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable";
$result = $conn->query($sql);

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


?>

<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>

<div class="container-fluid">
<div class="row">
<div class="col-xs-6">
<!--
display db table
-->
<h1> Product Table </h1>
<?php

if ($result->num_rows > 0) {
    echo
    "<table class=\"table table-striped\">
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
?>
</div>
<!-- divider to make middle of page -->

<div class="col-xs-6">
<!--
textbox for custom filename
if it is successful, make table
else echo error
-->
<?php
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

?>
<!--button: retrieve non-default file-->
<br>
<form action= <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>
 method="post">
<b>Load csv file to read</b><br>
Filename: <input type="text" name="inFile">
<input type="submit" value="Refresh">
</form>
<br>

<form action=<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> method="post">  
<b>Duplicates will be checked and skipped!</b> <br>
<input type="submit" name="csvToDB" value="Import CSV Data to DB Using Current File">

</form>

<br>


</div>
</div>
</div>


<!--button: write data from db to csv for backup-->
<form action= <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>
 method="post">
Filename: <input type="text" name="CSVoutFile">
<input type="submit" name="dbToCSV" value="Export ProductTable to CSV file">
</form>

<br>
</body>
</html>
