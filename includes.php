<?php
  // Configuration Files
  include './configs/sql.php';         // MySQL Config File
  include './configs/template.php';    // Smarty Template Engine

  // Classes
  include './core/DataBase.Class.php'; // MySQL Managment Class
  include './core/Security.Class.php'; // Class For Security Functions
  include './core/Core.Class.php';     // Core Class- Native Panel Functions
  include './core/User.Class.php';     // User Managment Class
  include './core/Server.Class.php';   // Server Managment Class
  include './core/Tickets.Class.php';  // Tickets Managment Class

  // Initializing Classes
  $DataBase = new DataBase();
  $Security = new Security();
  $Core     = new Core();
  $User     = new User();
  $Server   = new server();
  $Tickets  = new Tickets();

  //Initializing SSH2
  set_include_path('SSH2');
  include 'Net/SSH2.php';
  set_include_path('');

  // Initializing GameQ
  require_once 'GameQ/Autoloader.php';
  $GameQ = new \GameQ\GameQ();
?>
