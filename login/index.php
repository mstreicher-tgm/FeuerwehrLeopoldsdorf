<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/*" href="../other/images/icon.png">
    <link rel="stylesheet" href="../other/css/login.css">
    <title>Feuerwehr Leopoldsdorf | Login</title>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <?php
      session_start();
      require_once('../other/php/connection.php');
      require_once('../other/php/password.php');
      require_once('../other/php/functions.php');

      if(is_checked_in()) {
        $user = check_user();

        switch (strtolower($user['berechtigung'])) {
          case 'benutzer':
            header("location: /");
            break;

          case 'administrator':
            header("location: ../administrator");
            break;

          default:
            header("location: /");
            break;
        }
      }

      if(isset($_POST['login'])) {
        $standesbuchnummer = $_POST['standesbuchnummer'];
        $passwort = $_POST['passwort'];

        $statement = $pdo->prepare("SELECT * FROM userdata WHERE standesbuchnummer = :standesbuchnummer");
        $result = $statement->execute(array('standesbuchnummer' => $standesbuchnummer));
        $user = $statement->fetch();

        if ($user !== false && password_verify($passwort, $user['passwort'])) {
          $status = $user['status'];
          $berechtigung = $user['berechtigung'];

          if($status) {
            $_SESSION['userid'] = $user['id'];

            switch (strtolower($berechtigung)) {
              case 'benutzer':
                header("location: /");
                break;

              case 'administrator':
                header("location: ../administrator");
                break;

              default:
                header("location: /");
                break;
            }

          } else {
            echo "<script>Materialize.toast('Dein Account wurde noch nicht Aktiviert!', 5000);</script>";
          }
        } else {
          echo "<script>Materialize.toast('Standesbuchnummer oder Passwort ist falsch!', 5000);</script>";
        }
      }
    ?>
    <div class="section"></div>
    <main style="padding-top: 8%">
      <center>
        <div class="container">
          <div class="z-depth-1 white lighten-4 row" style="max-width: 600px; padding: 48px 48px 80px 48px; border: 1px solid #EEE;">
            <div class="center-align">
              <img src="../other/images/logo.png" class="responsive-img center-align" style="max-width: 350px" />
              <h6 style="margin-top: 2px">Mit deinem Konto anmelden</h6>
            </div>

            <form class="col s12" method="post">
              <div class='row'>
                <div class='col s12'>
                </div>
              </div>

              <div class='row'>
                <div class='input-field col s12'>
                  <input type='text' name='standesbuchnummer' id='standesbuchnummer' required />
                  <label for='standesbuchnummer'>Standesbuchnummer</label>
                </div>
              </div>

              <div class='row'>
                <div class='input-field col s12' style="margin-bottom: 25px;">
                  <input type='password' name='passwort' id='passwort' required />
                  <label for='passwort'>Passwort eingeben</label>
                </div>
                <div class="row">
                  <div class="col s6 left-align">
                    <a class="dropdown-button col s12 red-text text-darken-1" href='#' data-activates='dropdown1'>Weitere Optionen</a>

                    <ul id='dropdown1' class='dropdown-content' style="width: 300px !important">
                      <li><a href="../register" class="grey-text text-darken-2">Konto erstellen</a></li>
                    </ul>
                  </div>
                  <div class="col s6 right-align">
                    <button type='submit' name='login' class='btn waves-effect red darken-2' style="width: auto;">Anmelden</button>
                  </div>
                </div>
              </div>
              <br />
            </form>
          </div>
        </div>
      </center>
    </main>

    <script src="../other/js/login.js"></script>
  </body>
</html>
