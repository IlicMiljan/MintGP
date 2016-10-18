<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $Smarty->assign('Title', 'Serveri');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Servers');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $ServerList = $Server->GetServers();

  $Smarty->assign('Servers', $ServerList);
  $Smarty->display('servers.tpl');

  $Smarty->display('footer.tpl');
?>
