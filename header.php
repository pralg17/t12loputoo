<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Veini Pood</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
	<link href="../carousel/carousel.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../carousel/bootstrap.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </head>
<!-- NAVBAR
================================================== -->
  <body>
  
  
  <div style="height:100px" class="container">
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="True" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="frontpage.php">Veini Projekt</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-left">
                <li><a href="firma.php">Firmast</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Toote kirjeldus <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">veinid</li>
					<li><a href="valged.php">Valge vein</a></li>
                    <li><a href="punased.php">Punane vein</a></li>
                  </ul>
                </li>
				
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#login" data-toggle="modal" data-target="#myModal">Logi sisse</a></li>
				<li><a href="login.php">Registreeri</a></li>
			</ul>
            </div>
          </div>
        </nav>

      </div>
    </div>
  </div>
  <hr class="featurette-divider">
	  
	   <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
		
		  <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h3>Logi sisse</h3>
					</div>
					 <div class="modal-body">
					   <form method="post" action='login.php' name="login_form">
						 <p><input type="text" class="span3" name="loginEmail" id="email" placeholder="Email"></p>
						 <p><input type="password" class="span3" name="loginPassword" placeholder="Parool"></p>
						 <p><button type="submit" class="btn btn-primary">Logi sisse</button>
						   <a href="#">Unustasid parooli?</a>
						 </p>
					   </form>
					 </div>
				 <div class="modal-footer">
				   Pole veel kasutaja?
				   <a href="login.php" class="btn btn-primary">Registreeri</a>
				 </div>
			   </div>
			</div>
		</div>