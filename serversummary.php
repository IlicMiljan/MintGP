<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $ID = $Security->InputString($_GET['ID']);

  $ServerData = $Server->ServerData($ID);
  $Server->SetSSH2($ServerData['BoxID']);
  $TemplateData = $Server->TemplateData($ServerData['TemplateID']);
  $GameData = $Server->GameData($TemplateData['GameID']);
  $ServerData['GameName'] = $GameData['FullName'];

  if(isset($_GET['Action']) && isset($_GET['ID'])) {
    if($_GET['Action'] == 'Start') {
      $Server->StartServer($ID, TRUE);
    } elseif($_GET['Action'] == 'Stop') {
      $Server->StopServer($ID, TRUE);
    } elseif($_GET['Action'] == 'Restart') {
      $Server->RestartServer($ID);
    }
  }

  $Smarty->assign('Title', 'Pregled Servera');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Servers');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  if($ServerData['Status'] == '1') {
    $ServerQuery = $Server->ServerQuery($ID);
    $ServerQuery = $ServerQuery[$ServerData['ServerIP'].':'.$ServerData['ServerPort']];

    $ServerQueryData['Hostname'] = $ServerQuery[$GameData['QueryHostname']];
    $ServerQueryData['Maxplayers'] = $ServerQuery[$GameData['QueryMaxplayers']];
    $ServerQueryData['Numplayers'] = $ServerQuery[$GameData['QueryNumplayers']];
    $ServerQueryData['Mapname'] = $ServerQuery[$GameData['QueryMapname']];
    $ServerQueryData['GameMode'] = $ServerQuery[$GameData['QueryGameMode']];
    $Smarty->assign('ServerQuery', $ServerQueryData);
  }

  if(isset($_POST['ShowPassword'])) {
    $PIN = $_POST['PIN'];
    if($User->CheckPIN($PIN) == TRUE) {
      $Smarty->assign('FTP_Password', $ServerData['Password']);
    } else {
      $_SESSION['Error'] = 'Uuneli ste pogrešan PIN!';
      header('location: serversummary.php?ID='.$ID);
      exit();
    }
  }

  $Smarty->assign('ServerData', $ServerData);
  $Smarty->display('serversummary.tpl');

  $Smarty->display('footer.tpl');
?>
