<!--NAVBAR-->

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script>
$(document).ready(function() {
  //add to cart buttons

});
//id='quantity-input-{$row['id']}'> </td>

$(document).on('click', '[id^=add-to-cart-btn]', function( event ) {
  var rowId = $(event.target).attr('id').substring(16);//.attr("id");
  var quantity = $("#quantity-input-"+rowId.toString()).val();
  
  $.get('cartback.php', {'f': 1, 'pid': rowId, 'q': quantity}, function(data, status) {
    alert(data);
  });
});



  </script>
}
}
}
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">EnVision Parts Vending</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a>Products</a></li> <!--add link-->
      <li><a href="cart.php">Cart</a></li> <!--add link-->

      <!--Search Bar-->

      <li>
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>

          </button>
      </div>

      <div class="collapse navbar-collapse navbar-ex1-collapse">

          <div class="col-sm-40 col-md-60 pull-right">
          <form class="navbar-form" role="search">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="searchTerm" id="searchTerm">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
          </div>
          </form>
          </div>
      </div>
      </li>

      <li><a href="controlpanel.html">Control Panel</a><li>

      <!--Search-->

      </li>
    </ul>
  </div>
</nav>

</body>
</html>

<!--SIDEBAR-->

<div class="container-fluid">
<style>
.paddingtop {
    margin-top: 70px;

}
</style>

<div class="row paddingtop">
<!--id = "side-nav" class = "paddingtop" class="row">-->
  <div class="col-xs-2">
  <div class = "list-group">

<!--Collapsable List Small Parts-->

<a class="list-group-item list-group-item" data-toggle="collapse" href="#collapse1"><h4>Small Parts</h4></a>

<div id="collapse1" class="panel-collapse collapse">
    <a class="list-group-item list-group-item" href="#"><h5>> Nuts</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Bolts</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Screws</h5></a>
</div>

<!--Collapsable List Medium Parts-->

<a class="list-group-item list-group-item" data-toggle="collapse" href="#collapse2"><h4>Medium Parts</h4></a>

<div id="collapse2" class="panel-collapse collapse">
    <a class="list-group-item list-group-item" href="#"><h5>> Batteries</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Glue</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Breadboards</h5></a>
</div>

<!--Collapsable List Sheets-->

<a class="list-group-item list-group-item" data-toggle="collapse" href="#collapse3"><h4>Sheets</h4></a>

<div id="collapse3" class="panel-collapse collapse">
    <a class="list-group-item list-group-item" href="#"><h5>> Acrylic</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Plywood</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Metal</h5></a>

</div>
<!--Collapsable List Tubes-->

<a class="list-group-item list-group-item" data-toggle="collapse" href="#collapse4"><h4>Tubes</h4></a>

<div id="collapse4" class="panel-collapse collapse">
    <a class="list-group-item list-group-item" href="#"><h5>> PVC</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Square Tubing</h5></a>
    <a class="list-group-item list-group-item" href="#"><h5>> Wooden Dowels</h5></a>
</div>

</div>
</div>




<!--PHP main-->

    <div class="col-xs-10">
    <!--col-md-offset-2"-->
  <?php

  include 'connect.php';
  //search both by cate/descid and name/desc
  $searchID = -1;
  $searchTerm = "";
  if (isset($_GET["id"])) {
      $searchID = $_GET["id"];
  }

  if (isset($_GET["searchTerm"])) {
      $searchTerm = $_GET["searchTerm"];
      //echo "searchTerm: $searchTerm<br>";
  }

  ?>

  <?php

  if( $searchID != -1 ) {
  $sql = "SELECT * FROM ProductTable
          WHERE DescID=$searchID";
  //echo $sql."<br>";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
      echo
          //<h1>ID: $searchID</h1>
          "<table class=\"table table-striped\">
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
  //echo $sql."<br>";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
      echo

      //<h1>Term: $searchTerm</h1>
      "
          <table class=\"table table-striped\">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>CateID</th>
                  <th>Quantity Wanted</th>
                  <th>Add to Cart</th>
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
              <td> <input type='number' id='quantity-input-{$row['id']}'> </td>
              <td> <input type='button' id='add-to-cart-btn-{$row['id']}' value='Add To Cart'> </td>
              </tr>";
      }
      echo "</tbody></table>";
  } else {
      echo "0 results";
  }
  }

  //if( $searchID != -1 ) {
  $sql = "SELECT * FROM ProductTable
          WHERE DescID=7";
  //echo $sql."<br>";
  $result = $connection->query($sql);

  if ($result->num_rows > 0) {
      echo
          //<h1>ID: $searchID</h1>
          "
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
  ?>

</div>
</div>
</div>
</div>
</div>
<!--end main-->


</body>
</html>
