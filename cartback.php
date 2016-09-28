<?php

include 'connect.php';

foreach( $_GET as $cmd => $cmdVal ) {
    $cmdVal =  htmlspecialchars($cmdVal);
    
    switch( htmlspecialchars($cmd) ) {
    case 'd': // d for display :D
        // display product table if d==1

        if( $cmdVal == 1 ) {
            displayCartTable();
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
        break;
    }
}


function addToCart($pid, $q) {
//insert/add to cart
//$pid = product to add
//$q = quantity to add
$re = array_search($pid, array_column($_SESSION['cart'],0));
if( $re !== FALSE) {
  // found it in da column
  $_SESSION['cart'][$re][1] += $q;
} else {
  // not found in column :0
  $_SESSION['cart'][] = array($pid, $q);
}
unset($re);
}

function displayCartTable() {
	echo '<div id="cartTable">';
//output da table
	echo
        '
        <h1>Cart</h1>
        <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Set</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>';


	echo '</div>';
}

//cart controlz backend
function setQuantity($pid, $quantity) {
	global $connection;
  $sql = "SELECT quantity FROM ProductTable WHERE id={$pid}";
  $result = $connection->query($sql);
  if($result->num_rows > 1 || $result->num_rows == 0) {
    //bad - duplicate id's or not found 
    //throw in errLog
    return false;
  } else {
    //does this work? get the quantity from the query
    $max = $result->fetch_assoc()[0];
    if( $max < $quantity ) { 
    //throw in errorLog - inventory < quantity wanted!
      return false;
    }
  $re = array_search($pid, array_column($_SESSION['cart'],0));
  if( $re !== FALSE) { 
  // found it in da column
  $_SESSION['cart'][$re][1] = $quantity;

  } else {
    //error msg: pid updated is not in cart!
    return false;
  }
  unset($result);
  return true;
}

function getName($pid) {

	global $connection;
	$sql = "SELECT name FROM ProductTable where id={$pid}";
	$result = $connection->query($sql);
	if( $result->num_rows == 1) {
		$item = $result->fetch_array($result, MYSQLI_NUM );
		return $item[0];
	}
	echo "
      <div class='alert alert-danger fade in log-msg' id='logMsg'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Failure!</strong> Name for pid: {$pid} could not get name correctly! :(<br>
      Could either be pid not in db or duplicate id's in db
      </div>";
	return FALSE;
}

function deleteFromCart($pid) {
  $re = array_search($pid, array_column($_SESSION['cart'],0));
  if( $re !== FALSE) { 
    // found it in da column
    $productName = getName($pid);
    unset($_SESSION['cart'][$re]);
        echo "
            <div class='alert alert-success fade in log-msg' id='logMsg'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> {$} has been imported!
            </div>";
  } else {
    // not found, aka not in cart
  	//error log !!
  	echo "
      <div class='alert alert-danger fade in log-msg' id='logMsg'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Failure!</strong> {$pid} could not be deleted from cart! :(
      </div>";
    return false;
  }
}

?>