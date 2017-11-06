<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" type="image/*" href="../other/images/icon.png">
    <link rel="stylesheet" href="../other/css/chargen.css">
    <title>Feuerwehr Leopoldsdorf | Chargen Interface</title>
  </head>
  <body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

    <?php
      session_start();
      require_once('../other/php/connection.php');
      require_once('../other/php/password.php');
      require_once('../other/php/functions.php');

      if(is_checked_in() && is_chargen()) {
        $user = check_user();
      } else {
        header("location: ../login");
      }
    ?>

    <header>
      <div class="navbar-fixed">
        <nav class="red darken-4">
          <div class="nav-wrapper">
            <a href="#" class="brand-logo">
              <img class="logo" src="../other/images/logo.png" height="56px" />
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
              <?php if(is_administrator()) { ?>
              <li>
                <a href="../administrator" class="grey-text text-darken-1">
                  <i class="material-icons">dashboard</i> Admin Interface
                </a>
              </li>
              <li class="divider"></li>
              <?php } ?>
              <li>
                <a href="../passwort" class="grey-text text-darken-1">
                  <i class="material-icons">vpn_key</i> Passwort ändern
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="../logout" class="grey-text text-darken-1">
                  <i class="fa fa-sign-out fa-lg" style="margin-left: 3px;" aria-hidden="true"></i> Abmelden
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </div>

      <ul id="slide-out" class="side-nav fixed">
        <br>
        <li class="active">
          <a class="waves-effect red-text text-darken-4">
            <i class="material-icons red-text text-darken-4">dashboard</i> Übersicht
          </a>
        </li>

        <li>
          <a class="waves-effect" href="fahrzeuge">
            <i class="material-icons">directions_car</i> Fahrzeuge
          </a>
        </li>

        <li>
          <a class="waves-effect" href="geraete">
            <i class="material-icons">build</i> Geräte
          </a>
        </li>
      </ul>
    </header>

    <main>
      <br>

    </main>

    <script src="../../other/js/chargen.js"></script>
  </body>
</html>
