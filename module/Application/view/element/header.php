    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title><?php echo Core\App::$config->title . ' - ' . $title; ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="/res/css/bootstrap.css">


            <link href="/res/css/style.css" rel="stylesheet">

        </head>
    
        <body class="padding-top: 50px;">        
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


       <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Transparently</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/message/index/list">Wiadomości</a></li>
            <li><a href="/user/index/profile">Profil</a></li>
            <li><a href="/application/login/logout">Wyloguj</a></li>
          </ul>
        </div>
      </div>
    </nav>
     
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="/">Dashboard <span class="sr-only">(current)</span></a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/expense/index/list">Rachunki</a></li>
            <li><a href="/expense/cycle/list">Koszty cykliczne</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/expense/payment/list">Wpłaty</a></li>
            <li><a href="/expense/payment/add-payment">Nowa wpłata</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="/people/group/list">Grupy</a></li>
            <li><a href="/people/friend/list">Znajomi</a></li>
          </ul>
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="flash-msg-container">
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
          </div>
          <h1 class="page-header"><?php echo $title; ?></h1>

