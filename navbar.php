<!--NAVBAR-->

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<style>

.stylish-input-group .input-group-addon{
  background: white !important;
}
.stylish-input-group .form-control{
border-left:0;
box-shadow:0 0 0;
border-color:#ccc;
}
.stylish-input-group button{
  border:0;
  background:transparent;
}

</style>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">EnVision Parts Vending</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Products</a></li> <!--add link-->
      <li><a href="#">Cart</a></li> <!--add link-->

      <!--Search Bar-->
  
      <li>
      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
      </div>

      <div class="collapse navbar-collapse navbar-ex1-collapse">

          <div class="col-sm-40 col-md-60 pull-right">
          <form class="navbar-form" role="search">
          <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
              <div class="input-group-btn">
                  <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
          </div>
          </form>
          </div>
      </div>
      </li>

    </ul>
  </div>
</nav>

</body>
</html>

<!--SIDEBAR-->

<!DOCTYPE html>
<html>
<style>
body {
    font-family: "Lato", sans-serif;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 70px;
}

.sidenav a {
    padding: 3px 3px 0.5px 10px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 10px;
    font-size: 36px;
    margin-left: 50px;
    padding-top: 45px;
}

#main {
    transition: margin-left .5s;
    padding: 12px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

<!--Collapsable List Small Parts-->

<a data-toggle="collapse" href="#collapse1"><h4>Small Parts</h4></a>

<div id="collapse1" class="panel-collapse collapse">
    <a href="search.php?id=10"><h5>> Nuts</h5></a>
    <a href="search.php?id=11"><h5>> Bolts</h5></a>
    <a href="search.php?id=9"><h5>> Screws</h5></a>
</div>

<!--Collapsable List Medium Parts-->

<a data-toggle="collapse" href="#collapse2"><h4>Medium Parts</h4></a>

<div id="collapse2" class="panel-collapse collapse">
    <a href="#"><h5>> Batteries</h5></a>
    <a href="#"><h5>> Glue</h5></a>
    <a href="#"><h5>> Breadboards</h5></a>
</div>

<!--Collapsable List Sheets-->

<a data-toggle="collapse" href="#collapse3"><h4>Sheets</h4></a>

<div id="collapse3" class="panel-collapse collapse">
    <a href="#"><h5>> Acrylic</h5></a>
    <a href="#"><h5>> Plywood</h5></a>
    <a href="#"><h5>> Metal</h5></a>
</div>

<!--Collapsable List Tubes-->

<a data-toggle="collapse" href="#collapse4"><h4>Tubes</h4></a>

<div id="collapse4" class="panel-collapse collapse">
    <a href="#"><h5>> PVC</h5></a>
    <a href="#"><h5>> Square Tubing</h5></a>
    <a href="#"><h5>> Wooden Dowels</h5></a>
</div>

</div>

<div id="main">
  <br>
  <br>
  <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; </span>
</div>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "150px";
    document.getElementById("main").style.marginLeft = "150px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
</script>

</body>
</html>

<!--Table-->

<!DOCTYPE html>

<style>
  .ex1 {
      padding: 0cm 4cm 3cm 1.5cm;
  }
</style>
<body>

<div class="ex1">
  <h2>Small Parts</h2>
  <table class="table table-bordered">

    <thead>
      <tr>
        <th>id</th>
        <th>Product</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity Available</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td>Machine Screws/Bolts</td>
        <td>Doe</td>
        <td>john@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>

      </tr>
      <tr>
        <td></td>
        <td>Pan/Flat Head</td>
        <td>Moe</td>
        <td>mary@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Normal/Nylock</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Washers</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Normal/Lock</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Resistors</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Capacitors</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Transistors</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Diodes</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Op Amps</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Potentiometers</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Headers</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Crimp Connectors</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Rubber Bands</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Springs</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>

      <tr>
        <td></td>
        <td>Zip Ties</td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td></td>
        <td>
          <input type="number" name="quantity">
          <input type="submit" value="Add to Cart">
        </td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
