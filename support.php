<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $Smarty->assign('Title', 'Podrška');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Support');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Title = $Security->InputString($_POST['Title']);
    $ServerIP = $Security->InputString($_POST['ServerIP']);
    $Content = $Security->InputString($_POST['Content']);
    $Tickets->SubmitTicket($Title, $Content, $ServerIP);
  }
  
  $TicketList = $Tickets->GetTickets();

  $Smarty->assign('Tickets', $TicketList);
  $Smarty->display('support.tpl');

  $Smarty->display('footer.tpl');
?>
