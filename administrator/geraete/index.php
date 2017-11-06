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
        $geraet = $_POST['geraet'];
        $standort = $_POST['standort'];
        $statement = $pdo->prepare("INSERT INTO geraetedata (geraet, standort, status) VALUES (:geraet, :standort, 2)");
        $result = $statement->execute(array("geraet" => $geraet, "standort" => $standort));
        if($result) {
          echo "<script>Materialize.toast('Neues Gerät wurde erfolgreich eingetragen!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_POST['update'])) {
        $kommentar = $_POST['kommentar'];
        $kid = $_POST['update'];

        $statement = $pdo->prepare("UPDATE geraetedata SET kommentar = :kommentar WHERE id = :id");
        $result = $statement->execute(array("kommentar" => $kommentar, "id" => $kid));
        if($result) {
          echo "<script>Materialize.toast('Genauere informationen wurden zum Gerät hinzugefügt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['green'])) {
        $gid = $_GET['green'];
        $statement = $pdo->prepare("UPDATE geraetedata SET status = 2, kommentar = NULL WHERE id = :id");
        $result = $statement->execute(array("id" => $gid));
        if($result) {
          echo "<script>Materialize.toast('Status des Gerätes wurde auf \"Einsatzbereit\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['orange'])) {
        $oid = $_GET['orange'];
        $statement = $pdo->prepare("UPDATE geraetedata SET status = 1 WHERE id = :id");
        $result = $statement->execute(array("id" => $oid));
        if($result) {
          echo "<script>Materialize.toast('Status des Gerätes wurde auf \"Eingeschränkt\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['red'])) {
        $rid = $_GET['red'];
        $statement = $pdo->prepare("UPDATE geraetedata SET status = 0 WHERE id = :id");
        $result = $statement->execute(array("id" => $rid));
        if($result) {
          echo "<script>Materialize.toast('Status des Gerätes wurde auf \"Nicht Einsatzbereit\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['delete'])) {
        $rid = $_GET['delete'];
        $statement = $pdo->prepare("DELETE FROM geraetedata WHERE id = :id");
        $result = $statement->execute(array("id" => $rid));
      }

      $statement = $pdo->prepare("SELECT id, geraet, standort, status, kommentar FROM geraetedata");
      $result = $statement->execute();
      while ($liste = $statement->fetch()) {
        $geraete[] = $liste;
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

        <li>
          <a class="waves-effect" href="../benutzer">
            <i class="material-icons">account_circle</i> Benutzer
          </a>
        </li>

        <li>
          <a class="waves-effect" href="../fahrzeuge">
            <i class="material-icons">directions_car</i> Fahrzeuge
          </a>
        </li>

        <li class="active">
          <a class="waves-effect red-text text-darken-4">
            <i class="material-icons red-text text-darken-4">build</i> Geräte
          </a>
        </li>
      </ul>
    </header>

    <main>
      <br>
      <div class="row">
        <div class="col s12 m6 l7">
          <div class="card">
            <div class="card-content">
              <span class="card-title"><b>Geräteübersicht</b></span>
              <br>
              <p>
                Dies ist die Übersicht aller Geräte der Feuerwehr Leopoldsdorf. Die List enthält
                die Gerätebezeichnung, den Standort, den Status und die genaueren Statusinformationen.
                Hier können folgende Funktionen durchgeführt werden:<br><br>
                &nbsp;&nbsp;<b>+</b> Status aller Geräte verändern.<br>
                &nbsp;&nbsp;<b>+</b> Genauere Statusinformationen zu aller Geräte verändern.<br>
                &nbsp;&nbsp;<b>+</b> Neues Geräte in die Liste eitragen.
              </p>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l5">

          <div class="card">
            <div class="card-content">
              <span class="card-title"><b>Neues Gerät eintragen</b></span>
              <br>
              <form method="post">
                <div class="row">
                  <div class="input-field col s12 m12 l12">
                    <input id="geraet" name="geraet" type="text" required />
                    <label for="geraet">Gerät</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input id="standort" name="standort" type="text" required />
                    <label for="standort">Standort (Fahrzeug)</label>
                  </div>
                  <div class="col s12 center-align">
                    <button type="submit" name="register" class="btn waves-effect red darken-1" style="width: auto;">Hinzufügen</button>
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
                  <th>Gerät</th>
                  <th>Standort</th>
                  <th>Status</th>
                  <th class="hide-on-med-only">Genauere Informationen</th>
                  <th>Aktion</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    for($i = 0; $i < count($geraete); $i++) {
                      echo "<tr>";
                      echo "<td>".$geraete[$i][0]."</td>";
                      echo "<td>".$geraete[$i][1]."</td>";
                      echo "<td>".$geraete[$i][2]."</td>";
                      switch ($geraete[$i][3]) {
                        case 0:
                          echo "<td><span class=\"new badge red darken-1\" data-badge-caption=\"Nicht Einsatzbereit\"></span></td>";
                        break;
                        case 1:
                          echo "<td><span class=\"new badge orange darken-1\" data-badge-caption=\"Eingeschränkt\"></span></td>";
                        break;
                        case 2:
                          echo "<td><span class=\"new badge green\" data-badge-caption=\"Einsatzbereit\"></span></td>";
                        break;
                        default:
                          echo "<td><span class=\"new badge green\" data-badge-caption=\"Einsatzbereit\"></span></td>";
                        break;
                      }
                      echo "<td class=\"hide-on-med-only\" style=\"max-width: 100px\">".$geraete[$i][4]."</td>";
                      echo "<td><a class=\"btn btn-flat btn-floating dropdown-button waves-effect waves-light transparent\" data-constrainwidth=\"false\" data-activates=\"dropdown".$geraete[$i][0]."\"><i class=\"large black-text material-icons\">more_horiz</i></a></td>";
                      echo "</tr>";
                    }

                    for($i = 0; $i < count($geraete); $i++) {
                      echo "<ul id=\"dropdown".$geraete[$i][0]."\" class=\"dropdown-content auto-height\">";
                      switch ($geraete[$i][3]) {
                        case 0:
                          echo "<li><a href=\"?green=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
                          echo "<li><a href=\"?orange=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
                        break;
                        case 1:
                          echo "<li><a href=\"?green=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
                          echo "<li><a href=\"?red=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
                        break;
                        case 2:
                          echo "<li><a href=\"?orange=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
                          echo "<li><a href=\"?red=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
                        break;
                        default:
                          echo "<li><a href=\"?green=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
                          echo "<li><a href=\"?orange=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
                          echo "<li><a href=\"?red=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
                        break;
                      }
                      echo "<li><a class=\"grey-text text-darken-1 modal-trigger\" href=\"#infos".$geraete[$i][0]."\"><i class=\"material-icons\">message</i>Information bearbeiten</a></li>";
                      echo "<li class=\"divider\"></li>";
                      echo "<li><a href=\"?delete=".$geraete[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">delete</i> Löschen</a></li>";
                      echo "</ul>";
                    }

                    for($i = 0; $i < count($geraete); $i++) {
                      echo "<div id=\"infos".$geraete[$i][0]."\" class=\"modal\" style=\"max-width: 600px\">";
                        echo "<div class=\"modal-content\">";
                          echo "<form class=\"col s12\" method=\"post\">";
                            echo "<div class=\"row\">";
                              echo "<div class=\"input-field col s12\">";
                                if($geraete[$i][4] != null) {
                                  echo "<textarea id=\"kommentar\" name=\"kommentar\" class=\"materialize-textarea\" required>".$geraete[$i][4]."</textarea>";
                                } else {
                                  echo "<textarea id=\"kommentar\" name=\"kommentar\" class=\"materialize-textarea\" required></textarea>";
                                }
                                echo "<label for=\"kommentar\">Genauere Informationen: ".$geraete[$i][1]."</label>";
                                echo "<div class=\"col s12 center-align\">";
                                  echo "<button type=\"submit\" name=\"update\" value=\"".$geraete[$i][0]."\" class=\"btn waves-effect red darken-1\" style=\"width: auto;\">Aktualiesieren</button>";
                                echo "</div>";
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
