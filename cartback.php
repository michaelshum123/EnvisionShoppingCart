<?php

include 'connect.php';
session_start();
foreach( $_GET as $cmd => $cmdVal ) {
    $cmdVal =  htmlspecialchars($cmdVal);
    
    switch( htmlspecialchars($cmd) ) {
    case 'd': // d for display :D
        // display product table if d==1

        if( $cmdVal == 1 ) {
            displayCartTable();
        }

        
        if( $cmdVal == 3 ) {
          $pname = getName(12);
          
            echo  "
            <div class='alert alert-success log-msg' id='logMsg'>
                <a href='#' class='close fade in' data-dismiss='alert' aria-label='close'>&times;</a>
                <strong>Success!</strong> {$pname} potatopotato clafairy poop 
            </div>";  
        }

        break;

    case 'f':
        //add to cart
        if( $cmdVal == 1 ) {
          //TODO: Fill vars $_GET[] & SANATIZE

          addToCart($_GET['pid'], $_GET['q']); 

        }
        //update quanttiy
        if( $cmdVal == 2 ) {
          //TODO: fill vars $_GET{]} & SANITIZE
         // setQuantity($pid, $quantity);

        }
        //delete item from cart
        if( $cmdVal == 3) {
          //TODO: Fill var $_GET{}
          deleteFromCart($_GET['pid']);
        }
        //check out
        if( $cmdVal == 4) {
          //wowow

        }
        break;
    }
}

//dOES NOT CHECK IF IN DB!!
function addToCart($pid, $q) {
//insert/add to cart
//$pid = product to add
//$q = quantity to add
if( !isset($_SESSION['cart']) ) {
  // cart not set. time to make
  $_SESSION['cart'] = array();

}
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
	global $connection;
  
 
  echo '<div id="cartTable">';
//output da table
	echo
        '
        <h1>Cart</h1>
        <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Set</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>';

  if( !isset($_SESSION['cart'])) {
    echo '</table> </div>';
   
    return FALSE;
  }
 $total = 0.00;
  foreach ($_SESSION['cart'] as $cartRow) {
    //consider doing a huge || for id?? 
    $sql = "SELECT name, price FROM ProductTable WHERE id={$cartRow[0]}"; //TODO: PARAMETERIZE
    $result = $connection->query($sql);

    $resultArray = $result->fetch_array(MYSQLI_NUM); // should only return 1 id 
    echo "<tr> 
            <td>{$resultArray[0]}</td>
            <td>{$cartRow[1]}</td>
            <td>{$resultArray[1]}</td>
            <td> set button </td>
            <td class='text-center'> 
            <a href='#' id='delete-btn-{$cartRow[0]}' >
                <span class='glyphicon glyphicon-remove'></span>
            </a>   
            </td>
          </tr>
            "; 
    $total += (float) $resultArray[1] * (float) $cartRow[1];
  
  }

  echo '</table>';
  echo '<div class="well text-center col-xs-offset-8 col-xs-4">';
  echo "<b>Total: </b> {$total} ";
  echo '</div>';
  echo '</div>';


  unset($result);
}

//cart controlz backend
function setQuantity($pid, $quantity) {
	global $connection;
  
  $re = array_search($pid, array_column($_SESSION['cart'],0));
  if( $re !== FALSE) { 
  // found it in da column
  $_SESSION['cart'][$re][1] = $quantity;
  return true;
}
}

function getName($pid) {

	global $connection;
	$sql = "SELECT name FROM ProductTable where id={$pid}";
	$result = $connection->query($sql);
	if( $result->num_rows == 1) {
		$item = $result->fetch_array( MYSQLI_NUM );
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
                <strong>Success!</strong> {$productName} has been deleted from cart!
            </div>";
  } else {
    // not found, aka not in cart
  	//error log !!
  	echo "
      <div class='alert alert-danger fade in log-msg' id='logMsg'>
      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
      <strong>Failure!</strong> {$pid} was not found in cart! :(
      </div>";
    return false;
  }
}

//DO SERVER SIDED CHEX HERE
function checkOut(){
//1st step: validate all items in cart thru database (check quantity and db)
//throw err msg if not in db, duplicate ids, or quantity in db < quantity wanted
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
  }

  //go
}
?>

