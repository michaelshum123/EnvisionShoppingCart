window.msgid = 0;

// DO ALL BUTTON JQUERY/JS ACTIONS HERE
$(document).ready(function(){

    showProductTable();
    showCSVTable("", false);

    $("#dbToCSVButton").mouseup( 
        function () { 
            alert("dbToCSV!!");
            //exportDB(document.getElementById('dbToCSVfname').value) } 
        });


    $("#CSVtoDBButton").mouseup( 
        function () { 
            // pass through h1 elem of CSVTable, aka filename
            if( document.getElementById("owRB").checked || document.getElementById("skipRB").checked ) {
                alert($("#CSVTable > h1").text() + " radio:" + document.getElementById("skipRB").checked);
                importCSV( $("#CSVTable > h1").text(), document.getElementById("skipRB").checked);
            } else {
                alert("radioboxes are broken!");
            }
        });
    $("#CSVButton").mouseup( 
        function () { 
            //alert("CSV!!");
            refreshCSV( document.getElementById('CSVfname').value, true); 
        });
    $("#DaButton").mouseup(
        function() {
            $.get("controlpanelback.php",{d: 3}, 
            function(data, status) {
                if(status == "success") {
                    addLogMsg(data);
                } else {
                    alert("Something went wrong when loading back!\nStatus: "+status);
                }

            });
            
        });



});

//this will also hide confirm/discard buttons
function showModifyButton(id) {


}

//this will also show confirm/discard buttons
function hideModifyButton(id) {


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

//product table
function showProductTable() {
    $.get("controlpanelback.php",{d: 1}, 
        function(data, status) {
            if(status == "success") {
                $("#productTable").html(data);

                //if modify button is pressed, hide modify button and display Save/Discard Buttons, confirm
                //also, change row textboxes to enabled
                $('[id^=modify-btn]').click(
                function (event) { 
                    //grab id using substr, since modify-btn is constant # of chars
                    var rowId = $(event.target.parentNode).attr("id").substring(11);

                    var name = "#name-" + rowId;
                    var descrip = "#descrip-" + rowId;
                    var quantity = "#quantity-" + rowId;
                    var price = "#price-" + rowId;
                    var confirm = "#confirm-btn-" + rowId;
                    var discard = "#discard-btn-" + rowId;
                    //hide modify button, show confirm/discard
                    $(event.target.parentNode).attr("style", "display: none");
                    $(confirm).attr("style", "display: inline");
                    $(discard).attr("style", "display: inline");
                    //remove disabled properties if modify button been pressed
                    $(name).removeAttr('disabled');
                    $(descrip).removeAttr('disabled');
                    $(quantity).removeAttr('disabled');
                    $(price).removeAttr('disabled');
                });

                $('[id^=delete-btn]').click(
                function (event) { 
                    //grab id using substr, since modify-btn is constant # of chars
                    var rowId = $(event.target.parentNode).attr("id").substring(11);
                    deleteProduct(rowId);
                });


                $('[id^=confirm-btn]').click(
                function (event) {
                    var rowId = $(event.target.parentNode).attr("id").substring(12);

                    var name = "#name-" + rowId;
                    var descrip = "#descrip-" + rowId;
                    var quantity = "quantity-" + rowId;
                    var price = "price-" + rowId;
                    var modifyBtn = "#modify-btn-" + rowId;
                    var confirmBtn = "#confirm-btn-" + rowId;
                    var discardBtn = "#discard-btn-" + rowId;
                    
                    var allValid = true;
                    //confirm everything is valid first
                    if( !document.getElementById(price).validity.valid ) 
                        allValid = false;

                    if( !document.getElementById(quantity).validity.valid )

                    var result;
                    if( allValid ) {
                        result = confirm("Are you sure you want to save these changes?\n \
name: "+$(name).val()+"\n \
descrip: "+$(descrip).val()+"\n \
quantity: "+$(document.getElementById(quantity)).val()+"\n \
price: "+$(document.getElementById(price)).val());

                    } else {
                        alert("an input is invalid!");
                        return;
                    }
                    // confirm

                    //if so, set everything back to placeholder vals
                    if( result == true ) {
                        //ajax command to save stuff?
                        
                        //$(name).val()
                        $.get("controlpanelback.php", {'f': 4, 'id': rowId, 'name':name, 'des':descrip, 'quan':quantity, 'price': price}, 
                        function(data, status){
                            if (status == "success") {
                                //alert(data);
                                //set buttons, reupdate product table
                                alert(data);
                                $(name).attr('disabled',"disabled");
                                $(descrip).attr('disabled',"");
                                $(quantity).attr('disabled',"");
                                $(price).attr('disabled',"");                    
                                $(confirmBtn).attr("style", "display: none");
                                $(discardBtn).attr("style", "display: none");
                                $(modifyBtn).attr("style", "display: block");
                                showProductTable();
                                addLogMsg(data);

                            } else {
                                alert("Something went wrong when communicating with backend!\nStatus: "+status);
                            }
                    });
                    } //else do nothing
                    //hide buttons, show modify btn 
                    
                });
                $('[id^=discard-btn]').click(
                function (event) {
                    var rowId = $(event.target.parentNode).attr("id").substring(12);

                    var name = "#name-" + rowId;
                    var descrip = "#descrip-" + rowId;
                    var quantity = "#quantity-" + rowId;
                    var price = "#price-" + rowId;
                    var modifyBtn = "#modify-btn-" + rowId;
                    var confirmBtn = "#confirm-btn-" + rowId;
                    var discardBtn = "#discard-btn-" + rowId;
                                  
                    // confirm
                    var result = confirm("Are you sure you want to discard these changes?");
                    //if so, set everything back to placeholder vals
                    if( result == true ) {

                    $(name).attr('disabled',"").val($(name).attr('placeholder'));
                    $(descrip).attr('disabled',"").val($(descrip).attr('placeholder'));
                    $(quantity).attr('disabled',"").val($(quantity).attr('placeholder'));
                    $(price).attr('disabled',"").val($(price).attr('placeholder'));                    
                    $(confirmBtn).attr("style", "display: none");
                    $(discardBtn).attr("style", "display: none");
                    $(modifyBtn).attr("style", "display: block");
                    } //else do nothing
                    //hide buttons, show modify btn  

                });
            } else {    
                alert("Something went wrong when loading back!\nStatus: "+status);
            }

        });

}

//loads CSV table
//if fn is set, then a logMsg will appear
//if fn is not set, no msg will appear (assumes inital loading)
function showCSVTable(fn, printLog) {
    $.get("controlpanelback.php",{d: 2, 'CSVfname': fn}, 
        function(data, status) {
            if(status == "success") {
                // add return'd CSVTable to this CSVTable
                $("#CSVTable").html( $(data).filter("#CSVTable").html() );
                if(printLog == true) {
                    addLogMsg(data); // if fn is empty aka nothing, load default products.csv
                } 
            } else {    
                alert("Something went wrong when loading back!\nStatus: "+status);
            }

        });
}

function refreshCSV(fn) {
    var response = confirm("Are you sure you want to load " +fn+" ?");
     if (response == true) {
        //confirm, refresh CSV Table using jquery AJAX
        showCSVTable(fn,true);
    }
}

function deleteProduct(pid) {
    var response = confirm("Are you sure you want to delete id " + pid + "?");
    if (response == true) {
        /* sorry js, jquery is cooler
        //confirm, delete product using XMLHTTP request
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("logBox").innerHTML = this.responseText;
            }
        };

        //send POST
        xhttp.open("POST", "controlpanelback.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("pidToDelete="+pid); 
        */
        $.get("controlpanelback.php", {f: 3, pidToDelete: pid},
            function(data,status) {
                if(status == "success") {
                    addLogMsg(data);
                    showProductTable();
                    //alert(data);
                } else {
                    alert("Something went wrong when communicating with backend when deleting\n \
                            Product Name: " + $("#name-"+pid).attr('placeholder') + "\n \
                            ID: " + pid +"\n \
                            Status: "+status);
                }
            }
         );
    } 
}

function importCSV(fn, dupCheck) {
    var response = confirm("Are you sure you want to import current CSV to DB?");
    if(response == true) {
        //confirmed, start ajax
        
        $.get("controlpanelback.php",{f: 1, 'CSVfname': fn, duplicate: dupCheck}, 
            function(data, status) {
                if(status == "success") {
                    
                    showProductTable();
                    addLogMsg(data);
                } else {
                    alert("Something went wrong when loading "+fn+" !\nStatus: "+status);
                }

            });
        
    } else {
        //do nothing
    }
}

function exportDB(fn) {
    var response = confirm("Are you sure you want to export DB to " + fn + ".csv?");
    if(response == true) {
        //confirm, start XMLHttp Request
        $.get("controlpanelback.php", {'f':2, 'outFile':fn},
            function(data,status) {
                if( status == "success") {
                    addLogMsg(data);
                } else {
                    alert("Something went wrong wwhen communicating with backend!\nStatus: "+status+"\nData: "+data);
                }

            });
    } 
} 