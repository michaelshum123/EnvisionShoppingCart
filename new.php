<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful  <br>";
}

$sql = "CREATE DATABASE IF NOT EXISTS OnlineStoreDB";

if ($conn->query($sql) === TRUE) {
    echo "created OnlineStoreDB";
} else {
    echo "cannot create OnlineStoreDB :(" . $conn->error;
}

$sql = "USE OnlineStoreDB";
if ($conn->query($sql) === TRUE) {
    echo "now using OnlineStoreDB";
} else {
    echo "cannot use OnlineStoreDB :(" . $conn->error;
}
//$sql = "DROP TABLE ProductTable";


$sql = "CREATE TABLE IF NOT EXISTS ProductTable(
    id INTEGER(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    descrip VARCHAR(255) NOT NULL, 
    quantity INTEGER(4) NOT NULL,
    price DECIMAL(4,2) NOT NULL,
    descID INT(3) 
    )";
 
if ($conn->query($sql) === TRUE) {
    echo "created ProductTable";
} else {
    echo "cannot create ProductTable :(" . $conn->error;
}
 

?>

<html>
<head>
<title> fok da polize!!! </title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
<h1> DA TABLE </h1>
<?php
$sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable";
$result = $conn->query($sql);

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
                <th>descID</th>
            </tr>
        </thead>
        <tbody>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo 
            "<tr>
            <td>".$row["id"]."</td>
            <td>".$row["name"]."</td>
            <td>".$row["descrip"]."</td>
            <td>".$row["quantity"]."</td>
            <td>".$row["price"]."</td>
            <td>".$row["descID"]."</td>
            </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 results";
}
$conn->close();
?>


</body>



</html>

