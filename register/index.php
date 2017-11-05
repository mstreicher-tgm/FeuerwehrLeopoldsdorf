<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/*" href="../other/images/icon.png">
    <link rel="stylesheet" href="../other/css/register.css">
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

      if(isset($_POST['register'])) {
        $vorname = trim($_POST['vorname']);
        $nachname = trim($_POST['nachname']);
        $standesbuchnummer = trim($_POST['standesbuchnummer']);
        $dienstgrad = trim($_POST['dienstgrad']);
        $passwort = trim($_POST['passwort']);
        $passwort2 = trim($_POST['passwort2']);
        $berechtigung = "Benutzer";

        if((strlen($passwort) >= 8)) {
          if($passwort == $passwort2) {
            $statement = $pdo->prepare("SELECT * FROM userdata WHERE standesbuchnummer = :standesbuchnummer");
            $result = $statement->execute(array('standesbuchnummer' => $standesbuchnummer));
            $user = $statement->fetch();

            if($user == false) {
              $password_hash = password_hash($passwort, PASSWORD_DEFAULT);
              $statement = $pdo->prepare("INSERT INTO userdata (vorname, nachname, standesbuchnummer, dienstgrad, passwort, berechtigung, status) VALUES (:vorname, :nachname, :standesbuchnummer, :dienstgrad, :passwort, :berechtigung, false)");
              $result = $statement->execute(array('vorname' => $vorname, 'nachname' => $nachname, 'standesbuchnummer' => $standesbuchnummer, 'dienstgrad' => $dienstgrad, 'passwort' => $password_hash, 'berechtigung' => $berechtigung));

              if($result)  {
                echo "<script>Materialize.toast('Benutzer wurde erfolgreich angelegt!', 5000);</script>";
                echo "<script>setTimeout(function(){ window.location = '../login'; }, 5000);</script>";
              } else {
                echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
              }
            } else {
              echo "<script>Materialize.toast('Benutzer existiert bereits!', 5000);</script>";
            }
          } else {
            echo "<script>Materialize.toast('Passwörter stimmen nicht überein!', 5000);</script>";
          }
        } else {
          echo "<script>Materialize.toast('Passwort ist zu kurz, min. 8 Zeichen!', 5000);</script>";
        }
      }

      $statement = $pdo->prepare("SELECT id, kuerzel, dienstgrad, funktion FROM dienstgraddata");
      $result = $statement->execute();
      while ($liste = $statement->fetch()) {
        $dienstgrade[] = $liste;
      }
    ?>
    <div class="section"></div>
    <main style="padding-top: 4%">
      <center>
        <div class="container">
          <div class="z-depth-1 white lighten-4 row" style="max-width: 600px; padding: 48px 48px 80px 48px; border: 1px solid #EEE;">
            <div class="center-align">
              <img src="../other/images/logo.png" class="responsive-img center-align" style="max-width: 350px" />
              <h6 style="margin-top: 2px">Neues Konto erstellen</h6>
            </div>
            <br>
            <form class="col s12" method="post">
              <div class='row'>
                <div class='input-field col s6'>
                  <input type='text' name='vorname' id='vorname' required />
                  <label for='vorname'>Vorname</label>
                </div>

                <div class='input-field col s6'>
                  <input type='text' name='nachname' id='nachname' required />
                  <label for='nachname'>Nachname</label>
                </div>

                <div class='input-field col s12'>
                  <input type='text' name='standesbuchnummer' id='standesbuchnummer' required />
                  <label for='standesbuchnummer'>Standesbuchnummer</label>
                </div>

                <div class='input-field col s12'>
                  <select class="icons" id="dienstgrad" name="dienstgrad" required>
                    <option value="" disabled selected>Dienstgrad auswählen</option>
                    <?php
                      for($i = 0; $i < count($dienstgrade); $i++) {
                        echo "<option value='".$dienstgrade[$i][2]."' data-icon='../other/images/dienstgrade/".$dienstgrade[$i][1].".png' class='left circle'>".$dienstgrade[$i][2]."</option>";
                      }
                    ?>
                  </select>
                  <label for="dienstgrad">Dienstgrad</label>
                </div>

                <div class='input-field col s6'>
                  <input type='password' name='passwort' id='passwort' required />
                  <label for='passwort'>Passwort (min. 8 Zeichen)</label>
                </div>

                <div class='input-field col s6' style="margin-bottom: 25px;">
                  <input type='password' name='passwort2' id='passwort2' required />
                  <label for='passwort2'>Passwort wiederholen</label>
                </div>

                <div class="col s12 row">
                  <div class="col s6 left-align">
                    <a class="dropdown-button col s12 red-text text-darken-1" href='#' data-activates='dropdown1'>Weitere Optionen</a>

                    <ul id='dropdown1' class='dropdown-content' style="width: 300px !important">
                      <li><a href="../login" class="grey-text text-darken-2">Mit Konto anmelden</a></li>
                    </ul>
                  </div>
                  <div class="col s6 right-align">
                    <button type='submit' name='register' class='btn waves-effect red darken-2' style="width: auto;">Erstellen</button>
                  </div>
                </div>
              </div>
              <br />
            </form>
          </div>
        </div>
      </center>
    </main>

    <script src="../other/js/register.js"></script>
  </body>
</html>
