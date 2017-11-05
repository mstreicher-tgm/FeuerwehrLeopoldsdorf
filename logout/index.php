<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/*" href="../other/images/icon.png">
    <link rel="stylesheet" href="../other/css/logout.css">
    <title>Feuerwehr Leopoldsdorf | Logout</title>
  </head>
  <body onload="setTimeout(function(){ window.location = '../login'; }, 5000);">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <?php
      session_start();
      require_once('../other/php/connection.php');
      require_once('../other/php/password.php');
      require_once('../other/php/functions.php');

      if(is_checked_in()) {
        session_destroy();
        unset($_SESSION['userid']);
      } else {
        header("location: ../login");
      }
    ?>

    <div class="section"></div>
    <main style="padding-top: 12%">
      <center>
        <div class="container">
          <div class="z-depth-1 white lighten-4 row" style="max-width: 600px; padding: 48px 48px 80px 48px; border: 1px solid #EEE;">
            <div class="center-align">
              <img src="../other/images/logo.png" class="responsive-img center-align" style="max-width: 350px" />
              <h6 style="margin-top: 2px">Konto wird abgemeldet, Bitte warten...</h6>
            </div>

            <br><br>

            <div class="preloader-wrapper big extra active">
              <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left">
                  <div class="circle"></div>
                </div><div class="gap-patch">
                  <div class="circle"></div>
                </div><div class="circle-clipper right">
                  <div class="circle"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </center>
    </main>

    <script src="../other/js/logout.js"></script>
  </body>
</html>
