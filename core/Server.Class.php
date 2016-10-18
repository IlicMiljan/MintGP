<?php
  /**
   *
  */
  class Server
  {

    protected $SSH2_Host;
    protected $SSH2_Username;
    protected $SSH2_Password;
    protected $FTP_Host;
    protected $FTP_Username;
    protected $FTP_Password;

    public function GetServers()
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(CreateDate, '%d-%m-%Y') AS CreateDate, DATE_FORMAT(Expires, '%d-%m-%Y') AS Expires FROM Servers WHERE UserID = :UserID ORDER BY ID ASC");
      $DataBase->Bind(":UserID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();

      return $DataBase->ResultSet();
    }

    public function ServerData($ID)
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(Expires, '%d-%m-%Y') AS Expires FROM Servers WHERE ID = :ID AND UserID = :UserID");
      $DataBase->Bind(":ID", $ID);
      $DataBase->Bind(":UserID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();


      if($DataBase->RowCount() <> '1') {
        $_SESSION['Error'] = 'Server sa unetim identifikatorom nije pronađen!';
        header('location: servers.php');
        exit();
      }

      return $DataBase->Single();
    }

    public function TemplateData($ID)
    {
      global $DataBase;

      $DataBase->Query("SELECT * FROM Templates WHERE ID = :ID");
      $DataBase->Bind(":ID", $ID);
      $DataBase->Execute();

      if($DataBase->RowCount() <> '1') {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>TemplateError: '.$ID.'</b>]';
        header('location: servers.php');
        exit();
      }

      return $DataBase->Single();
    }

    public function GameData($ID)
    {
      global $DataBase;

      $DataBase->Query("SELECT * FROM Games WHERE ID = :ID");
      $DataBase->Bind(":ID", $ID);
      $DataBase->Execute();

      if($DataBase->RowCount() <> '1') {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>GameError: '.$ID.'</b>]';
        header('location: servers.php');
        exit();
      }

      return $DataBase->Single();
    }

    public function SetSSH2($BoxID)
    {
      global $DataBase;

      $DataBase->Query("SELECT * FROM Boxes WHERE ID = :ID");
      $DataBase->Bind(":ID", $BoxID);
      $DataBase->Execute();


      if($DataBase->RowCount() <> '1') {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>BoxError: '.$BoxID.'</b>]';
        header('location: servers.php');
        exit();
      }

      $Box = $DataBase->Single();

      $this->SSH2_Host     = $Box['BoxIP'];
      $this->SSH2_Username = $Box['Username'];
      $this->SSH2_Password = $Box['Password'];
    }

    protected function SSH2_Connect()
    {
      $SSH2 = new Net_SSH2($this->SSH2_Host);

      if (!$SSH2->login($this->SSH2_Username, $this->SSH2_Password)) {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>SSH2 Connection Error</b>]';
        header('location: servers.php');
        exit();
      }
      $SSH2->enablePTY();

      return $SSH2;
    }

    public function SetFTP($ID)
    {
      $ServerData = $this->ServerData($ID);
      $this->FTP_Host     = $ServerData['ServerIP'];
      $this->FTP_Username = $ServerData['Username'];
      $this->FTP_Password = $ServerData['Password'];
    }

    protected function FTP_Connect()
    {
      $FTP = ftp_connect($this->FTP_Host);

      if(!@ftp_login($FTP, $this->FTP_Username, $this->FTP_Password)) {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>FTP Connection Error</b>]';
        header('location: servers.php');
        exit();
      }

      return $FTP;
    }

    protected function SetStatus($ID, $Status)
    {
      global $DataBase;

      $DataBase->Query("UPDATE Servers SET Status = :Status WHERE ID = :ID AND UserID = :UserID");
      $DataBase->Bind(":Status", $Status);
      $DataBase->Bind(":ID", $ID);
      $DataBase->Bind(":UserID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();
    }


    public function StartServer($ID, $Redirect)
    {
      global $DataBase;

      $ServerData = $this->ServerData($ID);
      $ServerPath = "/home/".$ServerData['Username'];
      $TemplateData = $this->TemplateData($ServerData['TemplateID']);

      $StartOptions = array(
        '{$IP}'         => $ServerData['ServerIP'],
        '{$Port}'       => $ServerData['ServerPort'],
        '{$SlotNumber}' => $ServerData['SlotNumber']
      );

      $StartCommand = strtr($TemplateData['StartCommand'], $StartOptions);

      if($ServerData['Status'] == '1') {
        $_SESSION['Error'] = 'Ne možete pokrenuti već pokrenut server!';
        header('location: serversummary.php?ID='.$ID);
        exit();
      } else {
        $SSH2 = $this->SSH2_Connect();
        $SSH2->write("screen -S ".$ServerData['Username']."\n");
        $SSH2->setTimeout(1);
        $SSH2->write("cd ".$ServerPath."\n");
        $SSH2->setTimeout(1);
        $SSH2->write($StartCommand."\n");
        $SSH2->read();
        $SSH2->exec("chown -R ".$ServerData['Username'].":".$ServerData['Username']." ".$ServerPath);
        $SSH2->setTimeout(1);
        $SSH2->read();

        $this->SetStatus($ID, '1');

        if($Redirect == TRUE) {
          $_SESSION['Success'] = 'Uspešno ste pokrenuli server!';
          header('location: serversummary.php?ID='.$ID);
          exit();
        }
      }
    }

    public function StopServer($ID, $Redirect)
    {
      $ServerData = $this->ServerData($ID);

      if($ServerData['Status'] == '0') {
        $_SESSION['Error'] = 'Ne možete stopirati već stopiran server!';
        header('location: serversummary.php?ID='.$ID);
        exit();
      } else {
        $SSH2 = $this->SSH2_Connect();
        $SSH2->exec("screen -X -S '".$ServerData['Username']."' quit");
        $SSH2->setTimeout(1);
        $SSH2->read();

        $this->SetStatus($ID, '0');

        if($Redirect == TRUE) {
          $_SESSION['Success'] = 'Uspešno ste stopirali server!';
          header('location: serversummary.php?ID='.$ID);
          exit();
        }
      }
    }

    public function RestartServer($ID)
    {
      $ServerData = $this->ServerData($ID);

      if($ServerData['Status'] == '0') {
        $_SESSION['Error'] = 'Ne možete restartovati stopiran server!';
        header('location: serversummary.php?ID='.$ID);
        exit();
      } else {
        $SSH2 = $this->SSH2_Connect();
        $this->StopServer($ID, FALSE);
        $this->StartServer($ID, FALSE);

        $_SESSION['Success'] = 'Uspešno ste restartovali server!';
        header('location: serversummary.php?ID='.$ID);
        exit();
      }
    }

    public function AddUser($Username, $Password)
    {
      $SSH2 = $this->SSH2_Connect();
      $SSH2->exec("useradd -s /usr/sbin/nologin -m ".$Username);
      $SSH2->setTimeout(1);
      $SSH2->read();

      $SSH2->exec("echo ".$Username.":".$Password." | chpasswd");
      $SSH2->read();
    }

    public function RemoveUser($Username)
    {
      $SSH2 = $this->SSH2_Connect();
      $SSH2->exec("deluser -f --remove-home ".$Username);
      $SSH2->setTimeout(1);
      $SSH2->read();
    }

    public function ServerQuery($ID)
    {
      global $GameQ;

      $ServerData   = $this->ServerData($ID);
      $TemplateData = $this->TemplateData($ServerData['TemplateID']);
      $GameData     = $this->GameData($TemplateData['GameID']);

      $GameQ = new \GameQ\GameQ();
      $GameQ->addServer([
        'type'    => $GameData['QueryName'],
        'host'    => $ServerData['ServerIP'].':'.$ServerData['ServerPort'],
        'options' => [
          'query_port' => $ServerData['ServerPort'],
        ],
      ]);

      try {
        return @$GameQ->process();
      } catch (GameQ_Exception $e) {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>QueryConnError</b>]';
        header('location: servers.php');
        exit();
      }
    }

    public function RenameFolderFile($ID, $Dir, $OldName, $NewName)
    {
      $FTP_Conn = $this->FTP_Connect();

      ftp_chdir($FTP_Conn, $Dir);
      $Original_Directory = ftp_pwd($FTP_Conn);

      if(ftp_rename($FTP_Conn, $OldName, $NewName)) {
        $_SESSION['Success'] = 'Uspešno ste preimenovali željeni fajl/folder.';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      } else {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>RenameFileError</b>]';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }
      ftp_chdir($FTP_Conn, $Original_Directory);
    }

    public function CreateFolder($ID, $Dir, $FolderName)
    {
      $FTP_Conn = $this->FTP_Connect();

      ftp_chdir($FTP_Conn, $Dir);
      $Original_Directory = ftp_pwd($FTP_Conn);

      if(ftp_mkdir($FTP_Conn, $FolderName)) {
        $_SESSION['Success'] = 'Uspešno ste kreirali folder.';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      } else {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>CreateFolderError</b>]';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }
      ftp_chdir($FTP_Conn, $Original_Directory);
    }

    public function UploadFile($ID, $Dir, $File)
    {
      $UploadName = $File['name'];
      $Destination = $File['tmp_name'];
      $UploadSize = $File['size'];
      $Extension = pathinfo($UploadName, PATHINFO_EXTENSION);
      $RestrictedExtensions = 'exe,bat,php,sh';
      $RestrictedExtensions = explode(',', $RestrictedExtensions);

      $MaxSize = ini_get('upload_max_filesize');
      $MaxSize = trim($MaxSize);
      $Last = strtoupper($MaxSize[strlen($MaxSize)-1]);
      switch($Last) {
        case 'G':
          $MaxSize *= 1024;
        case 'M':
          $MaxSize *= 1024;
        case 'K':
          $MaxSize *= 1024;
      }

      if($UploadSize > $MaxSize || $UploadSize == '0') {
        $_SESSION['Error'] = 'Prekoračili ste dozvoljenu veličinu fajla!';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }

      if(in_array($Extension, $RestrictedExtensions)) {
        $_SESSION['Error'] = 'Tip fajla nije dozvoljen!';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }

      $FTP_Conn = $this->FTP_Connect();

      ftp_chdir($FTP_Conn, $Dir);
      $Original_Directory = ftp_pwd($FTP_Conn);

      if(ftp_put($FTP_Conn, $UploadName, $Destination, FTP_BINARY)) {
        $_SESSION['Success'] = 'Uspešno ste otpremili fajl.';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      } else {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>FileUploadError</b>]';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }
      ftp_chdir($FTP_Conn, $Original_Directory);
    }

    public function DeleteFile($ID, $Dir, $FileName)
    {
      $FTP_Conn = $this->FTP_Connect();

      $Original_Directory = ftp_pwd($FTP_Conn);
      ftp_chdir($FTP_Conn, $Dir);

      if(ftp_delete($FTP_Conn, $FileName)) {
        $_SESSION['Success'] = 'Uspešno ste obrisali željeni fajl.';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      } else {
        $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>DeleteFileError</b>]';
        header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
        exit();
      }
      ftp_chdir($FTP_Conn, $Original_Directory);
    }

    function FTP_List($ID, $Dir) {
      global $Core;
      global $Security;

      $FTP_Conn = $this->FTP_Connect();

      $Original_Directory = ftp_pwd($FTP_Conn);

      if(@ftp_chdir($FTP_Conn, $Dir)) {
        ftp_chdir($FTP_Conn, $Original_Directory);

        $FTP_Rawlist = ftp_rawlist($FTP_Conn, $Dir);
        foreach ($FTP_Rawlist as $V) {
          $Info = array();
          $Vinfo = preg_split('/[\s]+/', $V, 9);
          if ($Vinfo[0] !== 'total') {
            $Info['Chmod'] = $Vinfo[0];
            $Info['Num']   = $Vinfo[1];
            $Info['Owner'] = $Vinfo[2];
            $Info['Group'] = $Vinfo[3];
            $Info['Size']  = $Core->ConvertBytes($Vinfo[4], 1);
            $Info['Month'] = $Vinfo[5];
            $Info['Day']   = $Vinfo[6];
            $Info['Time']  = $Vinfo[7];
            $Info['Name']  = $Vinfo[8];

            $Rawlist[$Info['Name']] = $Info;
          }
        }

        $Dir = array();
        $File = array();
        foreach ($Rawlist as $K => $V) {
          if ($V['Chmod']{0} == 'd') {
            $Dir[$K] = $V;
          } elseif ($V['Chmod']{0} == '-') {
            $File[$K] = $V;
          }
        }

        $Files['Type'] = 'List';
        $Files['DIR'] = $Dir;
        $Files['FILE'] = $File;

        return $Files;
      }
      else {
        $TmpFile = tmpfile();
        $MetaData = stream_get_meta_data($TmpFile);
        $LocalFile = $MetaData['uri'];

        if(ftp_get($FTP_Conn, $LocalFile, $Dir, FTP_BINARY)) {
          $File['DATA'] = fread($TmpFile, filesize($LocalFile) + 1);
        } else {
          $_SESSION['Error'] = 'Došlo je do greške. Ukoliko se problem nastavi kontaktirajte administratora! [<b>GetFileError</b>]';
          header('location: webftp.php?ID='.$ID);
          exit();
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
          $FileContent = $Security->InputString($_POST['FileContent']);
          $TmpFile = tmpfile();

          fwrite($TmpFile, $FileContent);
          fseek($TmpFile, 0);
          $MetaData = stream_get_meta_data($TmpFile);
          $LocalFile = $MetaData['uri'];

          if (ftp_put($FTP_Conn, $Dir, $LocalFile, FTP_BINARY)) {
            $_SESSION['Success'] = 'Sadržaj fajla je uspešno izmenjen!';
            header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
            exit();
          } else {
            $_SESSION['Error'] = 'Došlo je do greške prilikom izmene sadržaja fajla. Pokušajte ponovo!';
            header('location: webftp.php?ID='.$ID.'&Path='.$Dir);
            exit();
          }
        }

        $File['Type'] = 'File';

        return $File;
      }
    }

  }

?>
