<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
window.msgid = 0;

$(document).ready( function() {
    displayCartTable();
    $(document).on('mouseup', '[id^=delete-btn]', function(event) {
        var rowId = $(event.target.parentNode).attr("id").substring(11);
        
        alert(rowId);
                //var quantity = $("#quantity-input-"+rowId).val();
        $.get('cartback.php', {f: 3, 'pid': rowId}, function(data, status) {
            addLogMsg(data);
            displayCartTable();
        });
    });

});

function displayCartTable() {


    $.get("cartback.php", {d: 1}, function(data, status) {
        if( status == "success") {
            
            $(document.getElementById("cartTable")).html(data);

        } else {
            alert("Something went wrong with displaying the cart!\nStatus: " + status);
            
        }
    });

}

//adds a log msg, sets unique id, and makes it fade in lol
function addLogMsg(data) {
//add unique val to id
    var logId = "logMsg" + window.msgid.toString();
    //add hidden and set id to unique val  
    var html = $(data).filter(".log-msg").addClass('hidden').prop("id", logId);
    
    //add to logBox
    $("#logBox").prepend( html ); 
                    //make logId a selector for jquery
    logId = "#" + logId;
                    //hide by logId
    //all this just to fadein
    $(logId).hide();
    $(logId).removeClass('hidden');
    $(logId).show(500);
    window.msgid++;
}

</script>
<title>Shooooping Cart</title>
</head>

<body>
<div class="container-fluid">

<div class="row">
<div class="col-xs-3">
</div>
<div class="col-xs-6" id="logBox">

</div>
<div class="col-xs-3">
</div>
</div>

<div class="row">
<div class="col-xs-3">

</div>
<div class="col-xs-6">
<div id="cartTable">

</div>
</div>

<div class="col-xs-3">
<div id="cartForm">
</div>
</div>

</div>
</div>

</body>
</html>