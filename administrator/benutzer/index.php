<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/*" href="../../other/images/icon.png">
    <link rel="stylesheet" href="../../other/css/administrator.css">
    <title>Feuerwehr Leopoldsdorf | Administrator Interface</title>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <?php
      session_start();
      require_once('../../other/php/connection.php');
      require_once('../../other/php/password.php');
      require_once('../../other/php/functions.php');

      if(is_checked_in() && is_administrator()) {
        $user = check_user();
      } else {
        header("location: ../../login");
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
              $statement = $pdo->prepare("INSERT INTO userdata (vorname, nachname, standesbuchnummer, dienstgrad, passwort, berechtigung, status) VALUES (:vorname, :nachname, :standesbuchnummer, :dienstgrad, :passwort, :berechtigung, true)");
              $result = $statement->execute(array('vorname' => $vorname, 'nachname' => $nachname, 'standesbuchnummer' => $standesbuchnummer, 'dienstgrad' => $dienstgrad, 'passwort' => $password_hash, 'berechtigung' => $berechtigung));

              if($result)  {
                echo "<script>Materialize.toast('Benutzer wurde erfolgreich angelegt!', 5000);</script>";
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
      elseif(isset($_GET['green'])) {
        $gid = $_GET['green'];
        $statement = $pdo->prepare("UPDATE userdata SET status = 1 WHERE id = :id");
        $result = $statement->execute(array("id" => $gid));
        if($result) {
          echo "<script>Materialize.toast('Der Benutzer wurde \"Aktiv\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['red'])) {
        $rid = $_GET['red'];
        $statement = $pdo->prepare("UPDATE userdata SET status = 0 WHERE id = :id");
        $result = $statement->execute(array("id" => $rid));
        if($result) {
          echo "<script>Materialize.toast('Der Benutzer wurde \"Inaktiv\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['delete'])) {
        $did = $_GET['delete'];
        $statement = $pdo->prepare("DELETE FROM userdata WHERE id = :id");
        $result = $statement->execute(array("id" => $did));
      }
      elseif(isset($_POST['password'])) {
        $pid = $_POST['password'];
        $passwort = trim($_POST['passwort']);
        $passwort2 = trim($_POST['passwort2']);

        if((strlen($passwort) >= 8)) {
          if($passwort == $passwort2) {
            $password_hash = password_hash($passwort, PASSWORD_DEFAULT);
            $statement = $pdo->prepare("UPDATE userdata SET passwort = :passwort WHERE id = :id");
            $result = $statement->execute(array('passwort' => $password_hash, 'id' => $pid));

            if($result)  {
              echo "<script>Materialize.toast('Passwort wurde erfolgreich geändert!', 5000);</script>";
            } else {
              echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
            }
          } else {
            echo "<script>Materialize.toast('Passwörter stimmen nicht überein!', 5000);</script>";
          }
        } else {
          echo "<script>Materialize.toast('Passwort ist zu kurz, min. 8 Zeichen!', 5000);</script>";
        }
      }
      elseif(isset($_POST['perm'])) {
        $pid = $_POST['perm'];
        $berechtigung = trim($_POST['berechtigung']);

        $statement = $pdo->prepare("UPDATE userdata SET berechtigung = :berechtigung WHERE id = :id");
        $result = $statement->execute(array('berechtigung' => $berechtigung, 'id' => $pid));

        if($result)  {
          echo "<script>Materialize.toast('Dienstgrad/Berechtigung wurden erfolgreich geändert!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_POST['rank'])) {
        $rid = $_POST['rank'];
        $dienstgrad = $_POST['dienstgrad'];
        $statement = $pdo->prepare("UPDATE userdata SET dienstgrad = :dienstgrad WHERE id = :id");
        $result = $statement->execute(array('dienstgrad' => $dienstgrad, 'id' => $rid));

        if($result)  {
          echo "<script>Materialize.toast('Dienstgrad/Berechtigung wurden erfolgreich geändert!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }

      $statement = $pdo->prepare("SELECT id, standesbuchnummer, vorname, nachname, dienstgrad, status, berechtigung FROM userdata");
      $result = $statement->execute();
      while ($liste = $statement->fetch()) {
        $benutzer[] = $liste;
      }

      $statement = $pdo->prepare("SELECT id, kuerzel, dienstgrad, funktion FROM dienstgraddata");
      $result = $statement->execute();
      while ($liste = $statement->fetch()) {
        $dienstgrade[] = $liste;
      }
    ?>

    <header>
      <div class="navbar-fixed">
        <nav class="red darken-4">
          <div class="nav-wrapper">
            <a href="#" class="brand-logo">
              <img class="logo" src="../../other/images/logo.png" height="56px" />
            </a>
            <a href="#" data-activates="slide-out" class="button-collapse">
              <i class="material-icons">menu</i>
            </a>

            <ul id="nav-mobile" class="right">
              <li>
                <a class="dropdown-button" href="#!" data-constrainwidth="false" data-beloworigin="true" data-activates="profileopt">
                  <span class="hide-on-large-only"><i class="material-icons large">account_circle</i></span>
                  <span class="hide-on-med-and-down">Hallo <?php echo $user['vorname']; ?>!</span>
                </a>
              </li>
            </ul>

            <ul id="profileopt" class="dropdown-content">
              <li>
                <a href="../../chargen" class="grey-text text-darken-1">
                  <i class="material-icons">dashboard</i> Chargen Interface
                </a>
              </li>
              <li class="divider"></li>
             <li>
               <a href="../../passwort" class="grey-text text-darken-1">
                 <i class="material-icons">vpn_key</i> Passwort ändern
               </a>
             </li>
             <li class="divider"></li>
             <li><a href="../../logout" class="grey-text text-darken-1"><i class="fa fa-sign-out fa-lg" style="margin-left: 3px;" aria-hidden="true"></i> Abmelden</a></li>
            </ul>
          </div>
        </nav>
      </div>

      <ul id="slide-out" class="side-nav fixed">
        <br>
        <li>
          <a class="waves-effect" href="../">
            <i class="material-icons">dashboard</i> Dashboard
          </a>
        </li>

        <li class="active">
          <a class="waves-effect red-text text-darken-4">
            <i class="material-icons red-text text-darken-4">account_circle</i> Benutzer
          </a>
        </li>

        <li>
          <a class="waves-effect" href="../fahrzeuge">
            <i class="material-icons">directions_car</i> Fahrzeuge
          </a>
        </li>

        <li>
          <a class="waves-effect" href="../geraete">
            <i class="material-icons">build</i> Geräte
          </a>
        </li>
      </ul>
    </header>

    <main>
      <br>
      <div class="row">
        <div class="col s12 m6 l6">
          <div class="card">
            <div class="card-content">
              <span class="card-title"><b>Benutzerübersicht</b></span>
              <br>
              <p>
                Dies ist die Übersicht aller Feuerwehrmitglieder der Feuerwehr Leopoldsdorf,
                die die Berechtigung haben wichtige Informationen einzutragen. Hier können
                olgende Funktionen durchgeführt werden:<br><br>
                &nbsp;&nbsp;<b>+</b> Status eines Benutzers ändern.<br>
                &nbsp;&nbsp;<b>+</b> Berechtigung eines Benutzers ändern.<br>
                &nbsp;&nbsp;<b>+</b> Neuen Benutzer im System anmelden.<br>
                &nbsp;&nbsp;<b>+</b> Dienstgrad eines Benutzer ändern.<br>
              </p>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l6">

          <div class="card">
            <div class="card-content">
              <span class="card-title"><b>Neuen Benutzer anlegen</b></span>
              <br>
              <form action="" method="post">
                <div class="row">
                  <div class="input-field col s12 m12 l6">
                    <input id="vorname" name="vorname" type="text" value="<?php if(isset($_GET['register'])) { echo($vorname); }?>" required />
                    <label for="vorname">Vorname</label>
                  </div>
                  <div class="input-field col s12 m12 l6">
                    <input id="nachname" name="nachname" type="text" value="<?php if(isset($_GET['register'])) { echo($nachname); }?>" required />
                    <label for="nachname">Nachname</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m12 l6">
                    <input id="standesbuchnummer" name="standesbuchnummer" type="text" value="<?php if(isset($_GET['register'])) { echo($standesbuchnummer); }?>" required />
                    <label for="standesbuchnummer">Standesbuchnummer</label>
                  </div>
                  <div class="input-field col s12 m12 l6">
                    <select class="icons" id="dienstgrad" name="dienstgrad" type="text" required>
                      <option value="" disabled selected>Dienstgrad auswählen</option>
                      <?php
                        for($i = 0; $i < count($dienstgrade); $i++) {
                          echo "<option value='".$dienstgrade[$i][2]."' data-icon='../../other/images/dienstgrade/".$dienstgrade[$i][1].".png' class='left circle'>".$dienstgrade[$i][2]."</option>";
                        }
                      ?>
                    </select>
                    <label for="dienstgrad">Dienstgrad</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m12 l6">
                    <input id="passwort" name="passwort" type="password" required />
                    <label for="passwort">Passwort (min. 8 Zeichen)</label>
                  </div>
                  <div class="input-field col s12 m12 l6">
                    <input id="passwort2" name="passwort2" type="password" required />
                    <label for="passwort2">Passwort wiederholen</label>
                  </div>
                  <div class="col s12 center-align">
                    <button type="submit" name="register" class="btn waves-effect red darken-1" style="width: auto;">Benutzer Erstellen</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col s12 m12 l12">
          <div class="card-panel">
            <table class="highlight centered responsive-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Standesbuchnummer</th>
                  <th>Vorname</th>
                  <th>Nachname</th>
                  <th colspan="2">Dienstgrad</th>
                  <th>Status</th>
                  <th>Berechtigung</th>
                  <th>Aktion</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    for($i = 0; $i < count($benutzer); $i++) {
                      $statement = $pdo->prepare("SELECT * FROM dienstgraddata WHERE dienstgrad = :dienstgrad");
                      $result = $statement->execute(array('dienstgrad' => $benutzer[$i][4]));
                      $dienstgrad = $statement->fetch();

                      $bid = $benutzer[$i][0];

                      echo "<tr>";
                      echo "<td>".$bid."</td>";
                      echo "<td>".$benutzer[$i][1]."</td>";
                      echo "<td>".$benutzer[$i][2]."</td>";
                      echo "<td>".$benutzer[$i][3]."</td>";
                      echo "<td class=\"hide-on-med-only\"><img src=\"../../other/images/dienstgrade/".$dienstgrad['kuerzel'].".png\" /></td>";
                      echo "<td>".$benutzer[$i][4]."</td>";

                      switch($benutzer[$i][5]) {
                        case true: echo "<td><span class=\"new badge green\" data-badge-caption=\"Aktiviert\"></span></td>"; break;
                        case false: echo "<td><span class=\"new badge red darken-1\" data-badge-caption=\"Deaktiviert\"></span></td>"; break;
                        default: echo "<td><span class=\"new badge red darken-1\" data-badge-caption=\"Fehler\"></span></td>"; break;
                      }
                      echo "<td><span class=\"new badge center-align\" data-badge-caption=\"".$benutzer[$i][6]."\"></span></td>";
                      echo "<td><a class=\"btn btn-flat btn-floating dropdown-button waves-effect waves-light transparent\" data-constrainwidth=\"false\" data-activates=\"dropdown".$bid."\"><i class=\"large black-text material-icons\">more_horiz</i></a></td>";
                      echo "</tr>";


                      echo "<ul id=\"dropdown".$bid."\" class=\"dropdown-content auto-height\">";
                        echo "<li><a href=\"#daendern".$bid."\" class=\"grey-text text-darken-1 modal-trigger\"><i class=\"material-icons\">star_rate</i> Dienstgrad</a></li>";
                        echo "<li><a href=\"#baendern".$bid."\" class=\"grey-text text-darken-1 modal-trigger\"><i class=\"material-icons\">lock</i>Berechtigung</a></li>";
                        echo "<li><a href=\"#paendern".$bid."\" class=\"grey-text text-darken-1 modal-trigger\"><i class=\"material-icons\">vpn_key</i> Passwort ändern</a></li>";
                        echo "<li class=\"divider\"></li>";
                        switch ($benutzer[$i][5]) {
                          case false: echo "<li><a href=\"?green=".$bid."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Aktivieren</a></li>"; break;
                          case true: echo "<li><a href=\"?red=".$bid."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Deaktivieren</a></li>"; break;
                          default: echo "<li><a href=\"?green=".$bid."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Aktivieren</a></li> <li><a href=\"?red=".$bid."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Deaktivieren</a></li>"; break;
                        }
                        echo "<li class=\"divider\"></li>";
                        echo "<li><a href=\"?delete=".$bid."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">delete</i> Löschen</a></li>";
                      echo "</ul>";
                    }

                    for($i = 0; $i < count($benutzer); $i++) {
                      $bid = $benutzer[$i][0];

                      echo "<div id=\"daendern".$bid."\" class=\"modal\" style=\"max-width: 500px\">";
                        echo "<div class=\"modal-content\">";
                          echo "<h4 class=\"center-align\">Dienstgrad ändern<br><small>(".$benutzer[$i][2]." ".$benutzer[$i][3].": ".$benutzer[$i][1].")</small></h4>";
                          echo "<form class=\"col s12\" method=\"post\">";
                            echo "<div class=\"row\">";
                              echo "<div class=\"input-field col s12\">";
                                echo "<input type=\"text\" id=\"dienstgrad\" name=\"dienstgrad\" class=\"autocomplete\" value=\"".$benutzer[$i][4]."\" required>";
                                echo "<label for=\"dienstgrad\">Dienstgrad</label>";
                              echo "</div>";
                              echo "<div class=\"col s12 center-align\">";
                                echo "<br><button type=\"submit\" name=\"rank\" value=\"".$bid."\" class=\"btn waves-effect red darken-1\" style=\"width: auto;\">Ändern</button><br><br>";
                              echo "</div>";
                            echo "</div>";
                          echo "</form>";
                        echo "</div>";
                      echo "</div>";
                    }

                    for($i = 0; $i < count($benutzer); $i++) {
                      $bid = $benutzer[$i][0];

                      echo "<div id=\"baendern".$bid."\" class=\"modal\" style=\"max-width: 500px\">";
                        echo "<div class=\"modal-content\">";
                          echo "<h4 class=\"center-align\">Berechtigung ändern<br><small>(".$benutzer[$i][2]." ".$benutzer[$i][3].": ".$benutzer[$i][1].")</small></h4>";
                          echo "<form class=\"col s12\" method=\"post\">";
                            echo "<div class=\"row\">";
                              echo "<div class=\"input-field col s12\">";
                                echo "<input type=\"text\" id=\"berechtigung\" name=\"berechtigung\" class=\"autocomplete\" value=\"".$benutzer[$i][6]."\" required>";
                                echo "<label for=\"berechtigung\">Berechtigung</label>";
                              echo "</div>";
                              echo "<div class=\"col s12 center-align\">";
                                echo "<button type=\"submit\" name=\"perm\" value=\"".$bid."\" class=\"btn waves-effect red darken-1\" style=\"width: auto;\">Ändern</button>";
                              echo "</div>";
                            echo "</div>";
                          echo "</form>";
                        echo "</div>";
                      echo "</div>";
                    }

                    for($i = 0; $i < count($benutzer); $i++) {
                      $bid = $benutzer[$i][0];

                      echo "<div id=\"paendern".$bid."\" class=\"modal\" style=\"max-width: 500px\">";
                        echo "<div class=\"modal-content\">";
                          echo "<h4 class=\"center-align\">Passwort ändern<br><small>(".$benutzer[$i][2]." ".$benutzer[$i][3].": ".$benutzer[$i][1].")</small></h4>";
                          echo "<form class=\"col s12\" method=\"post\">";
                            echo "<div class=\"row\">";
                              echo "<div class=\"input-field col s12\">";
                              echo "<input id=\"passwort\" name=\"passwort\" type=\"password\" required />";
                              echo "<label for=\"passwort\">Passwort ändern (min. 8 Zeichen)</label>";
                              echo "</div>";
                              echo "<div class=\"input-field col s12\">";
                                echo "<input id=\"passwort2\" name=\"passwort2\" type=\"password\" required />";
                                echo "<label for=\"passwort2\">Passwort wiederholen</label>";
                              echo "</div>";
                              echo "<div class=\"col s12 center-align\">";
                                echo "<button type=\"submit\" name=\"password\" value=\"".$bid."\" class=\"btn waves-effect red darken-1\" style=\"width: auto;\">Ändern</button>";
                              echo "</div>";
                            echo "</div>";
                          echo "</form>";
                        echo "</div>";
                      echo "</div>";
                    }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
    <script src="../../other/js/administrator.js"></script>
  </body>
</html>
