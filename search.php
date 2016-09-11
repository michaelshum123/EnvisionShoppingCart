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
//search both by cate/descid and name/desc
$searchID = -1;
$searchTerm = "";
if (isset($_GET["id"])) {
    $searchID = $_GET["id"];
}

if (isset($_GET["term"])) {
    $searchTerm = $_GET["term"];
    echo "searchTerm: $searchTerm<br>";
}


?>




<html>
<head>

</head>

<body>
<?php
if( $searchID != -1 ) {
$sql = "SELECT * FROM ProductTable
        WHERE DescID=$searchID";
echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo 
    "   <h1>ID: $searchID</h1>
        <table class=\"table table-striped\">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>CateID</th>
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
}

if( $searchTerm != "" ) {
$sql = "SELECT * FROM ProductTable
    WHERE name LIKE '%$searchTerm%' OR
    descrip LIKE '%$searchTerm%'";
echo $sql."<br>";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo 
    "   <h1>Term: $searchTerm</h1>
        <table class=\"table table-striped\">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>CateID</th>
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
}


?>
</body>


</html>
