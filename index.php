<?php
  session_start();
  include 'includes.php';

  $User->IsLoged();

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $Security->InputString($_POST['Username']);
    $Password = $Security->InputString($_POST['Password']);
    $User->LogIn($Username, $Password);
  }

  $Smarty->assign('Title', 'Prijava');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $Smarty->display('index.tpl');

  $Smarty->display('footer.tpl');

?>
