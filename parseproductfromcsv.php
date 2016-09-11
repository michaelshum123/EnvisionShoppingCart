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
} else {
    echo "Connection successful bitch \n";
}

//open csv file
$filename = "products.csv";
if (($handle = fopen($filename, "r")) !== FALSE) {
    //read header row
    fgetcsv($handle,600);
    
    while (($data = fgetcsv($handle, 600)) !== FALSE) {
        $sql = "INSERT INTO ProductTable 
            (name, descrip,quantity,price, descID)
            VALUES (\"$data[0]\", \"$data[1]\", $data[2], $data[3], $data[4] )";
        
        if ($conn->query($sql) === TRUE) {
        echo "Insert created successfully";
        } else {
        echo "Error inserting: " . $conn->error;
        }

    }
    fclose($handle);
}



$conn->close();
?>
