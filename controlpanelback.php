<?php
// Create connection
require 'connect.php';
//TODO: change SQL requests to parameterized stuff, change Get things to htmlspecialchars(),
//do SERVER SIDED CHECKS in the methods so error msgs can be relayed effectively

//command flags processed here
foreach( $_GET as $cmd => $cmdVal ) {
    $cmdVal =  htmlspecialchars($cmdVal);
    
    switch( htmlspecialchars($cmd) ) {
    case 'd': // d for display :D
        // display product table if d==1

        if( $cmdVal == 1 ) {
            displayProductTable();
        }

        // display csv table from filename
        if( $cmdVal == 2 ) {
            $fname = "";
            if(isset($_GET['CSVfname'])) {
                $fname =  $_GET['CSVfname'] ;
            }
            displayCSV($fname);   
        }
        if( $cmdVal == 3 ) {
            echo  "
            <div class='alert alert-success log-msg' id='msg'>
                <a href='#' class='close fade in' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> potatopotato clafairy poop 
            </div>";
            
        }
        break;

    case 'f':
        //import csv to db        
        if( $cmdVal == 1 ) {
            CSVToDb( $_GET['CSVfname'], filter_var($_GET['duplicate'], FILTER_VALIDATE_BOOLEAN) ); 
        }
        
        //save db to csv
        if( $cmdVal == 2 ) {
            dbToCSV( $_GET['outFile'] ); // SANITIZE HERE
        }
        
        if( $cmdVal == 3 ) {
            //single delete
            //delete item in db by pid
            //deletePid( $_GET['pidToDelete'] ); // SANiTIZE HERE
        
            deletePid($_GET['pidToDelete']);
        }
        
        if( $cmdVal == 4 ) {
            // single entry update
            //'id': rowId, 'name':name, 'des':descrip, 'quan':quantity, 'price': price
            //seUpdate($_GET['id'], )
            echo "potato";
        }
        break;
    default:
        break;
    }
    
}


// do functions here

function deletePid($pidToDelete) {
        global $connection;
        $sql = "DELETE FROM ProductTable WHERE id=".$pidToDelete; // TODO: Change to prepared statement
    
        if ($connection->query($sql) === TRUE) {
            echo "
            <div class='alert alert-success log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ID $pidToDelete has been deleted! 
            </div>"; 
        } else {
            echo "
            <div class='alert alert-danger log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> ID $pidToDelete could not be deleted! $connection->error 
            </div>";
        }
        
}

//TOOD: server sided form validation, parameterization
//single entry update
function seUpdate($idToUpdate, $n, $d, $q, $p ) {
    global $connection;

    //check if $id is in DB
    //check if name < maxchars
    //check if $d < maxChars
    //check if $q is a number
    //check if $p is decimal(4,2)

    $sql = "UPDATE ProductTable
            SET name={$n} descrip='{$d}', quantity={$q}, price={$p}
            WHERE id={$idToUpdate}";
    echo $sql . "\n";
    //$result = $connection->query($sql);


}


function dbToCSV( $outFile ) {
    global $connection;
    $success = TRUE;
    $sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable"; 
    $result = $connection->query($sql);
    //<!--write data from db to csv-->

if( strlen($outFile)!= 0 && $result->num_rows > 0 ){
    
    $list = array(
        array('id', 'name','descrip', 'quantity', 'price', 'descID')
    );
    while($row = $result->fetch_assoc()) {
        $list[] = array($row["id"], $row["name"] , $row["descrip"] ,
        $row["quantity"] ,  $row["price"] , $row["descID"]);
    }
    
    if (($outHandle = @fopen($outFile, "w")) !== FALSE) {
        foreach ($list as $line)
        {
            fputcsv($outHandle,$line);
        }
        fclose($outHandle);
    }else{
        //output cannot open file, write to csv failed
        $success = FALSE;
    }
} else {
    $success = FALSE;
        //error: strlen == 0 or result num_rows > 0 !!
}

    if($success == TRUE)
    {
        echo "
            <div class='alert alert-success' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Database has been saved to ${outFile}! 
            </div>"; 


    } else {
         //error: strlen == 0 or result num_rows > 0  OR fopen error
    echo "
            <div class='alert alert-danger' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> Database could not be saved to ${outFile}! DB could be empty, filename could be empty, or there are no file permissions
            </div>"; 

    }

    //free me!!
    unset($list);
    $result->free();

}


//CSV to db import!!
/*
$owOrSkip - false = overwrite, true = skip
-read CSV
-for each line, check if in DB
--OVERWRITE or SKIP !! 
-if not in db, just add
-logmsg
*/
function CSVToDb( $inFile, $owOrSkip ) {
    global $connection;
    
    $sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable"; 
    $result = $connection->query($sql);
    $nameColumn = array_column( $result->fetch_all(MYSQLI_ASSOC) , "name");

    //<!--write data from db to csv-->
    if ((file_exists($inFile) == TRUE) && (($inHandle = @fopen($inFile, "r")) !== FALSE)) {
    
        //read header row, ignore 
        $data = fgetcsv($inHandle,600);
    

    while (($data = fgetcsv($inHandle, 600)) !== FALSE) {
        
        if( array_search($data[0], $nameColumn) !== FALSE ) {

            //if found, check for update vs duplicate 
            if( $owOrSkip === TRUE ) {
                //found in name array + skip
                continue;
            } else {
                //found in name array + overwrite
                $sql = "UPDATE ProductTable
                        SET descrip='{$data[1]}', quantity={$data[2]}, price={$data[3]}, descID={$data[4]}
                        WHERE name='{$data[0]}'";
                $connection->query($sql);
            }
        } else {
            // add to db
            $sql = "INSERT INTO ProductTable (name, descrip, quantity, price, descID)
                    VALUES ('{$data[0]}' , '{$data[1]}', {$data[2]}, {$data[3]}, {$data[4]} );";
            $connection->query($sql);
        }
    }
    unset($data);
    fclose($inHandle);

   
        echo "
            <div class='alert alert-success fade in log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> {$inFile} has been imported!
            </div>";
    

    }else{
    //file did not open
    echo " 
            <div class='alert alert-danger fade in log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Failure!</strong> {$inFile} could not be loaded! Nothing has been imported.
            </div>"; 
    }

    $result->free();
    unset($nameColumn);
    //free variables!! 
    //$result->free();
    //$sql->free();
}
//pRODUCT TABLE!!!

function displayProductTable() {
    global $connection;

    $sql = "SELECT id, name, descrip, quantity, price, descID FROM ProductTable"; 
    $result = $connection->query($sql);
    
    echo "<div id='productTable'>";
if ($result->num_rows > 0) {
    echo
        '
        <h1>Product Table</h1>
        <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>CateID</th>
                <th>Delete</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody>';

    // output data of each row
    while($row = $result->fetch_assoc()) {
        
        echo
            "<tr";
        if( $row['quantity'] == 0 ) 
            echo " class='danger'";
        echo ">
            <td>{$row['id']}</td>
            <td>
                <input type='text' maxlength='255' style='width: 90px; height: 22px;' id='name-{$row['id']}' value='{$row['name']}' placeholder='{$row['name']}' disabled>    
            </td>
            <td>
                <input type='text' maxlength='255' style='width: 90px; height: 22px;' id='descrip-{$row['id']}' value='{$row['descrip']}' placeholder='{$row['descrip']}' disabled> 
            </td>
            <td>
                <input type='number' style='width: 40px; height: 22px;' id='quantity-{$row['id']}' value='{$row['quantity']}' placeholder='{$row['quantity']}' disabled>
            </td>
            <td>
                <input type='number' step='0.01' style='width: 50px; height: 22px;' id='price-{$row['id']}' value='{$row['price']}' placeholder='{$row['price']}' disabled>
            </td>
            <td>
            {$row['descID']}
            </td>

            <td class='text-center'> 
            <a href='#' id='delete-btn-{$row['id']}' >
                <span class='glyphicon glyphicon-remove'></span>
            </a>   
            </td>
            <td class='text-center'>
            <a href='#modify-btn-{$row['id']}' id='modify-btn-{$row['id']}' >
                <span class='glyphicon glyphicon-cog'></span>
            </a>
            <a href='#' id='confirm-btn-{$row['id']}' style='display: none'>
                <span class='glyphicon glyphicon-ok-sign' ></span>
            </a>
            <a href='#discard-btn-{$row['id']}' id='discard-btn-{$row['id']}' style='display: none'>
                <span class='glyphicon glyphicon-remove-sign'></span>
            </a>
            </td>
            </tr>";
    }
    echo "</tbody></table>";
    $result->free_result();
} else {
    echo "0 results";
}
    echo "</div>";
}
//csv TABLE

// open input csv file
function displayCSV( $inFile ) {
    $inFName = "";
    if ( strlen($inFile) != 0 )
    {
        $inFName = $inFile;
    } else {
        $inFName = "products.csv";
    }


    if ((file_exists($inFName) == TRUE) && (($inHandle = @fopen($inFName, "r")) !== FALSE)) {
    //read header row
    //fgetcsv($handle,600);
    echo
        "
        <div id='CSVTable'>
        <h1>$inFName</h1>
        <table class='table table-condensed table-bordered'>
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
    echo "</tbody></table></div>";
    fclose($inHandle);

   
        echo "
            <div class='alert alert-success fade in log-msg' id='logMsg'>
                <a href='#' class='close ' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> {$inFName} has been loaded!
            </div>";
    

}else{
    //file did not open
    echo " 
            <div class='alert alert-danger fade in log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Failure!</strong> {$inFName} could not be loaded! 
            </div>"; 
}

}


?>
