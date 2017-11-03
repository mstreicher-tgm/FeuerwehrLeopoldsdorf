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

    <main>
      <form method="post">
        <input type="text" placeholder="standesbuchnummer" name="standesbuchnummer" required />
        <input type="password" placeholder="Passwort" name="passwort" required />
        <input type="submit" name="login" />
      </form>
    </main>

    <script src="../other/js/login.js"></script>
  </body>
</html>
