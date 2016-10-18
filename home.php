<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $Smarty->assign('Title', 'Početna');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Home');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $News = $Core->GetNews();

  $Smarty->assign('News', $News);
  $Smarty->display('home.tpl');

  $Smarty->display('footer.tpl');
?>
