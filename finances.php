<?php
  session_start();
  include 'configs/sql.php';
  include 'configs/template.php';
  include 'core/Core.class.php';
  include 'core/User.class.php';

  $Core = new Core();
  $User = new User();

  $User->SessionCheck($CONN);

  $Smarty->assign('Title', 'Finansije');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Finances');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $Smarty->display('finances.tpl');

  $Smarty->display('footer.tpl');
?>
