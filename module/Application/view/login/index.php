<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo Core\App::$config->title . ' - ' . $title; ?></title>

        <link rel="stylesheet" href="/res/css/bootstrap.css">
        <link href="/res/css/style.css" rel="stylesheet">
    </head>
  <body style="padding-top: 40px; padding-bottom: 40px;">
     <script>
          var dojoConfig = {
              async: 1,
              packages: [
                  { name: "bootstrap", location: "/res/js/dojo-bootstrap" }
              ]
          };
      </script>
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/dojo/1.10.4/dojo/dojo.js"></script>
      <script type="text/javascript" src="/res/js/base.js"></script>

      <?php
        foreach ($flashMsg['error'] as $key => $msg) { 
          echo '<p class="flash-msg bg-warning">'. $msg .'</p>';
        }

        foreach ($flashMsg['info'] as $key => $msg) { 
          echo '<p class="flash-msg bg-info">'. $msg .'</p>'; 
        }

        foreach ($flashMsg['success'] as $key => $msg) { 
          echo '<p class="flash-msg bg-success">'. $msg .'</p>';
        }
      ?>
      
      <div class="container">
          <form class="form-signin" method="POST" action="/application/login/login">
              <h2 class="form-signin-heading">Cześć, zaloguj się</h2>
              <label for="inputEmail" class="sr-only">E-mail</label>
              <input type="login" id="inputEmail" class="form-control" placeholder="E-mail" name="login" required autofocus>
              <label for="inputPassword" class="sr-only">Hasło</label>
              <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Hasło" required>
              <div class="checkbox">
                 Nie masz konta Transparently? <a href="/application/login/signup">Utwórz konto</a>
              </div>
              <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>
          </form>
      </div>
  </body>
</html>
