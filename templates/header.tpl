<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Mint GP :: {$Title}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="templates/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="templates/css/flat-ui.min.css" rel="stylesheet">
    <link href="templates/css/sweetalert.css" rel="stylesheet">
    <link href="templates/css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.ico">
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-embossed" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
          <span class="sr-only">Navigacija</span>
        </button>
        <a class="navbar-brand" href="index.php">Mint GP</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse-01">
        <ul class="nav navbar-nav navbar-left">
          {if isset($ShowNavigation)}
          <li><a href="home.php">Početna{if $Active eq 'Home'}<span class="navbar-unread">1</span>{/if}</a></li>
          <li><a href="servers.php">Serveri{if $Active eq 'Servers'}<span class="navbar-unread">1</span>{/if}</a></li>
          <li><a href="finances.php">Finansije{if $Active eq 'Finances'}<span class="navbar-unread">1</span>{/if}</a></li>
          <li><a href="support.php">Podrška{if $Active eq 'Support'}<span class="navbar-unread">1</span>{/if}</a></li>
          <li><a href="profile.php">Profil{if $Active eq 'Profile'}<span class="navbar-unread">1</span>{/if}</a></li>
          <li><a href="logout.php">Izlaz{if $Active eq 'Logout'}<span class="navbar-unread">1</span>{/if}</a></li>
          {/if}
         </ul>
         <form class="navbar-form navbar-right" action="" role="search">
          <div class="form-group">
            <div class="input-group">
              <input class="form-control" id="navbarInput-01" name="Test" type="search" placeholder="Pretraga ...">
              <span class="input-group-btn">
                <button type="submit" class="btn"><span class="fui-search"></span></button>
              </span>
            </div>
          </div>
        </form>
      </div>
    </nav>
    {$Message}
