<?php
  /**
   *
   */
  class User
  {

    public function LogIn($Username, $Password)
    {
      global $DataBase;
      global $Security;

      $DataBase->Query("SELECT ID, Username, Password FROM Users WHERE Username = :Username");
      $DataBase->Bind(":Username", $Username);
      $DataBase->Execute();
      $UserData = $DataBase->Single();
      $UserCount = $DataBase->RowCount();

      if($UserCount == "1" && $Security->VerifyHash($Password, $UserData["Password"])) {
        $_SESSION['UserLogin']['ID'] = $UserData["ID"];
        $_SESSION['UserLogin']['Username'] = $UserData["Username"];

        header('location: home.php');
        exit();
      } else {
        $_SESSION['Error'] = 'Uneli ste netačne podatke. Pokušajte ponovo!';

        header('location: index.php');
        exit();
      }
    }

    public function SessionCheck()
    {
      global $DataBase;
      global $Core;

      $UserCheck = $_SESSION['UserLogin']['ID'];

      $DataBase->Query("SELECT * FROM Users WHERE ID = :ID");
      $DataBase->Bind(":ID", $UserCheck);
      $DataBase->Execute();
      $UserData = $DataBase->Single();

      if(!isset($UserData["Username"])){
        header('location: logout.php');
        exit();
      }

      $DataBase->Query("UPDATE Users SET LastIP = :LastIP, LastActivity = CURRENT_TIMESTAMP() WHERE ID = :ID");
      $DataBase->Bind(":LastIP", $Core->GetIP());
      $DataBase->Bind(":ID", $UserCheck);
    }

    public function IsLoged()
    {
      if(isset($_SESSION['UserLogin'])) {
        header('location: home.php');
        exit();
      }
    }

    public function UserData()
    {
      global $DataBase;

      $DataBase->Query("SELECT * FROM Users WHERE ID = :ID");
      $DataBase->Bind(":ID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();

      return $DataBase->Single();
    }

    public function UpdateProfile($FirstName, $LastName, $Password, $EmailAddress, $PIN)
    {
      global $DataBase;
      global $Security;
      global $Core;

      $UpdateOK = '1';

      $Core->CheckForEmpty(array('FirstName', 'LastName', 'Password', 'EmailAddress', 'PIN'), 'profile.php');

      if($this->CheckPIN($PIN)) {
        $UpdateOK = '1';
      } else {
        $UpdateOK = '0';
        $_SESSION['Error'] = 'Uneli ste netačan PIN kod. Podaci profila nisu izmenjeni!';
        header('location: profile.php');
        exit();
      }

      if($UpdateOK == '1') {
        $DataBase->Query("UPDATE Users SET FirstName = :FirstName, LastName = :LastName, Password = :Password, EmailAddress = :EmailAddress WHERE ID = :ID");
        $DataBase->Bind(":FirstName",    $FirstName);
        $DataBase->Bind(":LastName",     $LastName);
        $DataBase->Bind(":Password",     $Password);
        $DataBase->Bind(":EmailAddress", $EmailAddress);
        $DataBase->Bind(":ID",           $_SESSION['UserLogin']['ID']);
        $DataBase->Execute();
        
        $_SESSION["Success"] = 'Uspešno ste izmenili podatke svog profila.';
        header('location: profile.php');
        exit();
      } else {
          $_SESSION['Error'] = 'Došlo je do greške prilikom izmene podataka. Pokušajte ponovo!';
          header('location: profile.php');
          exit();
      }
    }

    public function CheckPIN($PIN)
    {
      global $Security;

      $UserData = $this->UserData();

      if($Security->VerifyHash($PIN, $UserData['PIN'])) {
        return TRUE;
      } else {
        return FALSE;
      }
    }

  }

?>
