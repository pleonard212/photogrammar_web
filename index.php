<?php $page = home; ?>
<?php include 'header.php'; ?>


    <!-- Main jumbotron -->
    <div class="jumbotron" style="padding-top:100px">
      <div class="container">
        <h1>Welcome!</h1>
	<p>Photogrammar is a web-based platform for organizing, searching, and visualizing the 170,000 photographs from 1935 to 1945 created by the United State’s Farm Security Administration and Office of War Information (FSA-OWI). </p>
        <p><a class="btn btn-primary btn-lg" href="/map" role="button">Start exploring &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Interactive Map</h2>
          <p> The map plots the approximately 90,000 photographs that have geographical information.  Customize your search by by photographer, date, and place.</p>
          <p><a class="btn btn-default" href="/map" role="button">See map &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <!-- <img class="img" src="img" alt="partner" height=150px> -->
          <h2>About The Collection</h2>
          <p> Today housed at the Library of Congress, the archive primarily depicts life in America during the Great Depression and World War II. </p>
          <p><a class="btn btn-default" href="/about/fsa_owi" role="button">Read more &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Visualizations</h2>
          <p>  Delve into the Photogrammar Labs where visualizations techniques are being used in order to shed new light on the archive. </p>
          <p><a class="btn btn-default" href="/labs" role="button">View labs &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p></p>
      </footer>
    </div> <!-- /container -->


<?php include 'footer.php'; ?>
