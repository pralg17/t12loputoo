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
          <h2 class="featurette-heading">Veini Projekt</h2>
          <p class="lead">siia tuleb pikk seletus firmast ja selle tekkimisest ja ajaloost ja muust sellisest asjast.</p>

        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive center-block" src="../carousel/loodus.jpg" alt="Generic placeholder image">
        </div>
      </div>

	
	

      <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->

  </body>
</html>
    
<?php require("../footer.php");?>