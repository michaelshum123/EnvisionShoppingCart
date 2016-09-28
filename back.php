<?php

// do php things
require 'connect.php';
session_start();


foreach( $_GET as $cmd => $cmdVal ) {
    $cmdVal =  htmlspecialchars($cmdVal);
    
    switch( htmlspecialchars($cmd) ) {
    case 'd': // d for display :D
        // display product table if d==1

        if( $cmdVal == 1 ) {
            
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
    	if( $cmdVal == 1 ) {

    	}
    break;

	}
}


?>