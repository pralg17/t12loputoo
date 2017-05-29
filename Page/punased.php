<?php 	require("../functions.php");
		if (!isset($_SESSION["userId"])){
			require("../header.php");	
		} else require ("../header2.php");
?>
<!DOCTYPE html>

	<div class="container marketing">
	 <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">punane vein 1.</h2>
          <p class="lead">PunanePunanePunanePunanePunanePunanePunanePunanePunane</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="../carousel/images.jpg" alt="Generic placeholder image">
        </div>
      </div>
	   <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">punane vein 2.</h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="../carousel/images.jpg" alt="Generic placeholder image">
        </div>
      </div>
	   <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">punane vein 3.</h2>
          <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="../carousel/images.jpg" alt="Generic placeholder image">
        </div>
      </div>
	
	

      <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->

  </body>
</html>
    
<?php require("../footer.php");?>