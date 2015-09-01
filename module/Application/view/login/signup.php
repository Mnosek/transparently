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
      <script type="text/javascript" src="/Application/res/js/signup.js" ></script>

      <div class="container">
          <form class="form-signup" method="POST" action="/application/login/create-user" onsubmit="return validateForm()">
              <h2 class="form-signin-heading">Wypełnij formularz</h2>
              <label for="inputName" class="sr-only">Imię</label>
              <input type="text" id="inputName" class="form-control" placeholder="Imię" name="name" required autofocus>
              <label for="inputLastName" class="sr-only">Nazwisko</label>
              <input type="text" id="inptLastName" class="form-control" placeholder="Nazwisko" name="last_name" required autofocus>
              <label for="inputEmail" class="sr-only">Email</label>
              <input type="email" id="inputLastName" class="form-control" placeholder="Email" name="email" required autofocus>
              <label for="inputPassword" class="sr-only">Hasło</label>
              <input type="password" id="inputPassword" class="form-control" placeholder="Hasło" name="password" required autofocus>
              <label for="inputPasswordRepeat" class="sr-only">Powtórz hasło</label>
              <input type="password" id="inputPasswordRepeat" class="form-control" name="password_repeat" placeholder="Powtórz hasło" required>
              <button class="btn btn-lg btn-primary btn-block" type="submit">Dołącz!</button>
          </form>
      </div>
  </body>
</html>
