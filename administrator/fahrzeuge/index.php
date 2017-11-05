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
        $funkbezeichnung = $_POST['funkbezeichnung'];
        $fahrzeug = $_POST['fahrzeug'];
        $statement = $pdo->prepare("INSERT INTO fahrzeugdata (funkbezeichnung, fahrzeug, status) VALUES (:funkbezeichnung, :fahrzeug, 2)");
        $result = $statement->execute(array("funkbezeichnung" => $funkbezeichnung, "fahrzeug" => $fahrzeug));
        if($result) {
          echo "<script>Materialize.toast('Neues Fahrzeug wurde erfolgreich eingetragen!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_POST['update'])) {
        $kommentar = $_POST['kommentar'];
        $kid = $_POST['update'];

        $statement = $pdo->prepare("UPDATE fahrzeugdata SET kommentar = :kommentar WHERE id = :id");
        $result = $statement->execute(array("kommentar" => $kommentar, "id" => $kid));
        if($result) {
          echo "<script>Materialize.toast('Genauere informationen wurden zum Fahrzeug hinzugefügt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['green'])) {
        $gid = $_GET['green'];
        $statement = $pdo->prepare("UPDATE fahrzeugdata SET status = 2, kommentar = NULL WHERE id = :id");
        $result = $statement->execute(array("id" => $gid));
        if($result) {
          echo "<script>Materialize.toast('Status des Fahrzeuges wurde auf \"Einsatzbereit\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['orange'])) {
        $oid = $_GET['orange'];
        $statement = $pdo->prepare("UPDATE fahrzeugdata SET status = 1 WHERE id = :id");
        $result = $statement->execute(array("id" => $oid));
        if($result) {
          echo "<script>Materialize.toast('Status des Fahrzeuges wurde auf \"Eingeschränkt\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['red'])) {
        $rid = $_GET['red'];
        $statement = $pdo->prepare("UPDATE fahrzeugdata SET status = 0 WHERE id = :id");
        $result = $statement->execute(array("id" => $rid));
        if($result) {
          echo "<script>Materialize.toast('Status des Fahrzeuges wurde auf \"Nicht Einsatzbereit\" gesetzt!', 5000);</script>";
        } else {
          echo "<script>Materialize.toast('Etwas ist schief gelaufen, versuche es erneut!', 5000);</script>";
        }
      }
      elseif(isset($_GET['delete'])) {
        $did = $_GET['delete'];
        $statement = $pdo->prepare("DELETE FROM fahrzeugdata WHERE id = :id");
        $result = $statement->execute(array("id" => $did));
      }

      $statement = $pdo->prepare("SELECT id, funkbezeichnung, fahrzeug, status, kommentar FROM fahrzeugdata");
      $result = $statement->execute();
      while ($liste = $statement->fetch()) {
        $fahrzeuge[] = $liste;
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
               <a href="../../profile" class="grey-text text-darken-1">
                 <i class="material-icons">account_box</i> Mein Profil
               </a>
             </li>
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

        <li class="active">
          <a class="waves-effect red-text text-darken-4">
            <i class="material-icons red-text text-darken-4">directions_car</i> Fahrzeuge
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
              <span class="card-title"><b>Fahrzeugübersicht</b></span>
              <br>
              <p>
                Dies ist die Übersicht aller Fahrzeuge der Feuerwehr Leopoldsdorf. Die List enthält
                die funkbezeichnung, die Fahrzeugbezeichnung, den Status und die genaueren Statusinformationen.
                Hier können folgende Funktionen durchgeführt werden:<br><br>
                &nbsp;&nbsp;<b>+</b> Status aller Fahrzeuge verändern.<br>
                &nbsp;&nbsp;<b>+</b> Genauere Statusinformationen zu aller Fahrzeugen verändern.<br>
                &nbsp;&nbsp;<b>+</b> Neues Fahrzeug in die Liste eitragen.
              </p>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l6">

          <div class="card">
            <div class="card-content">
              <span class="card-title"><b>Neues Fahrzeug eintragen</b></span>
              <br>
              <form method="post">
                <div class="row">
                  <div class="input-field col s12 m12 l12">
                    <input id="funkbezeichnung" name="funkbezeichnung" type="text" required />
                    <label for="funkbezeichnung">Funkbezeichnung</label>
                  </div>
                  <div class="input-field col s12 m12 l12">
                    <input id="fahrzeug" name="fahrzeug" type="text" required />
                    <label for="fahrzeug">Fahrzeug</label>
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
                  <th>Funkbezeichnung</th>
                  <th>Fahrzeug</th>
                  <th>Status</th>
                  <th class="hide-on-med-only">Genauere Informationen</th>
                  <th>Aktion</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  for($i = 0; $i < count($fahrzeuge); $i++) {
                    echo "<tr>";
                    echo "<td>".$fahrzeuge[$i][0]."</td>";
                    echo "<td>".$fahrzeuge[$i][1]."</td>";
                    echo "<td>".$fahrzeuge[$i][2]."</td>";
                    switch ($fahrzeuge[$i][3]) {
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
                    echo "<td class=\"hide-on-med-only\" style=\"max-width: 100px\">".$fahrzeuge[$i][4]."</td>";
                    echo "<td><a class=\"btn btn-floating btn-flat dropdown-button waves-effect waves-light transparent\" data-constrainwidth=\"false\" data-activates=\"dropdown".$fahrzeuge[$i][0]."\"><i class=\"large black-text material-icons\">more_horiz</i></a></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <?php
      for($i = 0; $i < count($fahrzeuge); $i++) {
        echo "<ul id=\"dropdown".$fahrzeuge[$i][0]."\" class=\"dropdown-content auto-height\">";
          switch ($fahrzeuge[$i][3]) {
            case 0:
              echo "<li><a href=\"?green=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
              echo "<li><form method=\"post\"><button href=\"?green=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
              echo "<li><a href=\"?orange=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
            break;
            case 1:
              echo "<li><a href=\"?green=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
              echo "<li><a href=\"?red=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
            break;
            case 2:
              echo "<li><a href=\"?orange=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
              echo "<li><a href=\"?red=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
            break;
            default:
              echo "<li><a href=\"?green=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">check_circle</i> Einsatzbereit</a></li>";
              echo "<li><a href=\"?orange=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">warning</i> Eingeschränkt</a></li>";
              echo "<li><a href=\"?red=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">block</i> Nicht Einsatzbereit</a></li>";
            break;
          }
          echo "<li><a class=\"grey-text text-darken-1 modal-trigger\" href=\"#infos".$fahrzeuge[$i][0]."\"><i class=\"material-icons\">message</i>Information bearbeiten</a></li>";
          echo "<li class=\"divider\"></li>";
          echo "<li><a href=\"?delete=".$fahrzeuge[$i][0]."\" class=\"grey-text text-darken-1\"><i class=\"material-icons\">delete</i> Löschen</a></li>";
        echo "</ul>";


        echo "<div id=\"infos".$fahrzeuge[$i][0]."\" class=\"modal\" style=\"max-width: 600px\">";
          echo "<div class=\"modal-content\">";
            echo "<form class=\"col s12\" method=\"post\">";
              echo "<div class=\"row\">";
                echo "<div class=\"input-field col s12\">";
                  if($fahrzeuge[$i][4] != null) {
                    echo "<textarea id=\"kommentar\" name=\"kommentar\" class=\"materialize-textarea\" required>".$fahrzeuge[$i][4]."</textarea>";
                  } else {
                    echo "<textarea id=\"kommentar\" name=\"kommentar\" class=\"materialize-textarea\" required></textarea>";
                  }
                  echo "<label for=\"kommentar\">Genauere Informationen: ".$fahrzeuge[$i][2]."</label>";
                  echo "<div class=\"col s12 center-align\">";
                    echo "<button type=\"submit\" name=\"update\" value=\"".$fahrzeuge[$i][0]."\" class=\"btn waves-effect red darken-1\" style=\"width: auto;\">Aktualiesieren</button>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</form>";
          echo "</div>";
        echo "</div>";
      }
    ?>

    <script src="../../other/js/administrator.js"></script>
  </body>
</html>
