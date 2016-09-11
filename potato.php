<?php
$servername = "localhost";
$username = "root";
$password = "";
#$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful bitch \n";
} 

$sql = "CREATE DATABASE IF NOT EXISTS wowDB";
if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
} else {
        echo "Error creating database: " . $conn->error;
}

$sql = "USE wowDB";
if ($conn->query($sql) === TRUE) {
    echo "now using wowDB";
} else {
    echo "cannot use wowDB :(" . $conn->error;
}


$sql = "CREATE TABLE MyTable ( 
    id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    size INT(4) UNSIGNED 
)";

if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
} else {
        echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO MyTable (size)
    VALUES ( 420 )";

if ($conn->query($sql) === TRUE) {
        echo "Insert created successfully";
} else {
        echo "Error inserting: " . $conn->error;
}

$sql = "SELECT id, size FROM MyTable";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
        echo "<table><tr><th></th><th>Size</th></tr>";
        // output data of each row
        while($row = $result->fetch_assoc()) {
echo "<tr><td>".$row["id"]."</td><td>".$row["size"]." </td></tr>";
        }
  echo "</table>";
    } else {
     echo "0 results";
}

//bai 
$conn->close();
?>
<html>

<title> fok da polize!! </title>
<body>
</body>

</html>
