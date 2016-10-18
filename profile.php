<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $Smarty->assign('Title', 'Profil');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Profile');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $UserData = $User->UserData();

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FirstName = $_POST['FirstName'];
    $LastName = $_POST['LastName'];
    $Password = $_POST['Password'];
    $EmailAddress = $_POST['EmailAddress'];
    $PIN = $_POST['PIN'];
    $Password = $Security->Hash($Password);
    $User->UpdateProfile($FirstName, $LastName, $Password, $EmailAddress, $PIN);
  }

  $Smarty->assign('UserData', $UserData);
  $Smarty->display('profile.tpl');

  $Smarty->display('footer.tpl');
?>
