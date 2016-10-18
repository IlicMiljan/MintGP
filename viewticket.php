<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $Smarty->assign('Title', 'Pogledaj Tiket');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Support');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TicketID = $_POST['TicketID'];
    $Content = $_POST['Content'];
    $Tickets->SubmitAnswer($TicketID, $Content);
  }
  if(isset($_GET['Action']) && isset($_GET['TicketID']) && $_GET['Action'] == 'CloseTicket') {
    $TicketID = $_GET['TicketID'];
    $Tickets->CloseTicket($TicketID);
  }

  $Ticket = $Tickets->SelectTicket($_GET['ID']);

  $Smarty->assign('Ticket', $Ticket);
  $Smarty->assign('Answers', $Tickets->SelectAnswers($Ticket['ID']));
  $Smarty->display('viewticket.tpl');

  $Smarty->display('footer.tpl');
?>
