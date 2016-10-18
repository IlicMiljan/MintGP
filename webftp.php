<?php
  session_start();
  include 'includes.php';

  $User->SessionCheck();

  $ID = $Security->InputString($_GET['ID']);

  $ServerData = $Server->ServerData($ID);
  $Server->SetFTP($ID);

  if(isset($_GET['Path']) && !empty($_GET['Path']) && $_GET['Path'] !== '/' ) {
    $Path = $Security->InputString($_GET['Path']);
  } else {
    $Path = '.';
  }

  $FTP_List = $Server->FTP_List($ID, $Path);
  $Crumb = explode("/", $Path);
  $NewPath = '';
  foreach($Crumb as $Value) {
    $NewPath .= $Value;
    $Navigation[] = array('Link' => $NewPath, 'Name' => $Value);
    $NewPath .= '/';
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['Rename'])) {
      $OldName = $Security->InputString($_POST['OldName']);
      $NewName = $Security->InputString($_POST['NewName']);

      $Server->RenameFolderFile($ID, $Path, $OldName, $NewName);
    } elseif(isset($_POST['CreateFolder'])) {
      $FolderName = $Security->InputString($_POST['FolderName']);
      $Server->CreateFolder($ID, $Path, $FolderName);
    } elseif(isset($_POST['UploadFile'])) {
      $File = $_FILES['File'];
      $Server->UploadFile($ID, $Path, $File);
    }
  }

  if(isset($_GET['Action']) && $_GET['Action'] == 'Delete') {
    $FileName = $_GET['File'];
    $Server->DeleteFile($ID, $Path, $FileName);
  }

  $Smarty->assign('Title', 'WEB FTP');
  $Smarty->assign('ShowNavigation', '');
  $Smarty->assign('Active', 'Servers');
  $Smarty->assign('Message', $Core->GetMessage());
  $Smarty->display('header.tpl');

  $Smarty->assign('Navigation', $Navigation);
  $Smarty->assign('CurrentPath', $Path);
  $Smarty->assign('ServerData', $ServerData);
  if($FTP_List['Type'] == 'List') {
    $Smarty->assign('DirList', $FTP_List['DIR']);
    $Smarty->assign('FileList', $FTP_List['FILE']);
  } elseif($FTP_List['Type'] == 'File') {
    $Smarty->assign('FileData', $FTP_List['DATA']);
  }
  $Smarty->assign('MaxUploadSize', ini_get('upload_max_filesize'));
  $Smarty->display('webftp.tpl');

  $Smarty->display('footer.tpl');
?>
