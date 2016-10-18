<?php
  /**
   *
   */
  class Core
  {

    public function GetMessage()
    {
      $Message = "";
      if(isset($_SESSION["Success"])) {
        $Message = '<div class="alert alert-success">'.$_SESSION["Success"].'</div>';
        unset($_SESSION['Success']);
      } elseif(isset($_SESSION["Error"])) {
        $Message = '<div class="alert alert-danger">'.$_SESSION["Error"].'</div>';
        unset($_SESSION['Error']);
      }
      return $Message;
    }

    public function CheckForEmpty($Required, $Location)
    {
      foreach($Required as $Field) {
        if(empty($_POST[$Field])) {
          $_SESSION["Error"] = "Morate popuniti sva polja označena *";
          header("location: ".$Location);
          exit();
        }
      }
    }

    public function GetIP()
    {
      if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $IP = $_SERVER["HTTP_CLIENT_IP"];
      } elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
      } elseif(!empty($_SERVER["HTTP_X_FORWARDED"])) {
        $IP = $_SERVER["HTTP_X_FORWARDED"];
      } elseif(!empty($_SERVER["HTTP_FORWARDED_FOR"])) {
        $IP = $_SERVER["HTTP_FORWARDED_FOR"];
      } elseif(!empty($_SERVER["HTTP_FORWARDED"])) {
        $IP = $_SERVER["HTTP_FORWARDED"];
      } elseif(!empty($_SERVER["REMOTE_ADDR"])) {
        $IP = $_SERVER["REMOTE_ADDR"];
      } else {
        $IP = "Nepoznata!";
      }
      return $IP;
    }

    public function ConvertTimestamp($Timestamp)
    {
      $Format = 'H:i d-m-Y';
      $DTO = new DateTime($Timestamp);
      return $DTO->format($Format);
    }

    function ConvertBytes($Bytes, $Precision = 2) {
    $Units = array('B', 'KB', 'MB', 'GB', 'TB');

    $Bytes = max($Bytes, 0);
    $Pow = floor(($Bytes ? log($Bytes) : 0) / log(1024));
    $Pow = min($Pow, count($Units) - 1);

    $Bytes /= pow(1024, $Pow);

    return round($Bytes, $Precision) . ' ' . $Units[$Pow];
}

    public function GetNews()
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(PostDate, '%H:%i | %d-%m-%Y') AS PostDate FROM News ORDER BY ID DESC");
      $DataBase->Execute();

      return $DataBase->ResultSet();
    }

  }

?>
