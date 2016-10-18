<?php
  /**
   *
   */
  class Tickets
  {

    public function GetTickets()
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(SubmitDate, '%d-%m-%Y') AS SubmitDate FROM Tickets WHERE UserID = :UserID ORDER BY ID DESC");
      $DataBase->Bind(":UserID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();

      return $DataBase->Resultset();
    }

    public function SubmitTicket($Title, $Content, $ServerIP)
    {
      global $DataBase;
      global $Core;

      $SubmitOK = '1';
      $Content = nl2br($Content);

      $Core->CheckForEmpty(array('Title', 'Content', 'ServerIP'), 'support.php');

      if(strlen($Title) < '10') {
        $SubmitOK = '0';
        $_SESSION['Error'] = 'Naslov mora biti duži od 10 karaktera!';
        header('location: support.php');
        exit();
      } elseif(strlen($Content) < '50') {
        $SubmitOK = '0';
        $_SESSION['Error'] = 'Sadržaj mora biti duži od 50 karaktera!';
        header('location: support.php');
        exit();
      }

      if($SubmitOK == '1') {
        $DataBase->Query("INSERT INTO Tickets (UserID, Status, Title, Content, ServerIP) VALUES (:UserID, :Status, :Title, :Content, :ServerIP)");
        $DataBase->Bind(":UserID",   $_SESSION['UserLogin']['ID']);
        $DataBase->Bind(":Status",   "0");
        $DataBase->Bind(":Title",    $Title);
        $DataBase->Bind(":Content",  $Content);
        $DataBase->Bind(":ServerIP", $ServerIP);
        $DataBase->Execute();

        $_SESSION['Success'] = 'Uspešno ste otvorili novi tiket, bićete obavešteni kada administracija odgovori na isti.';
        header('location: support.php');
        exit();
      } else {
          $_SESSION['Error'] = 'Došlo je do greške prilikom otvaranja tiketa. Pokušajte ponovo!';
          header('location: support.php');
          exit();
      }
    }

    public function SelectTicket($ID)
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(SubmitDate, '%H:%i | %d-%m-%Y') AS SubmitDate FROM Tickets WHERE ID = :ID AND UserID = :UserID");
      $DataBase->Bind(":ID", $ID);
      $DataBase->Bind(":UserID", $_SESSION['UserLogin']['ID']);
      $DataBase->Execute();

      if($DataBase->RowCount() <> '1') {
        $_SESSION['Error'] = 'Došlo je do greške prilikom prikazivanja / zatvaranja tiketa. Pokušajte ponovo!';
        header('location: support.php');
        exit();
      }

      return $DataBase->Single();
    }

    public function SelectAnswers($TicketID)
    {
      global $DataBase;

      $DataBase->Query("SELECT *, DATE_FORMAT(SubmitDate, '%H:%i | %d-%m-%Y') AS SubmitDate FROM TicketAnswers WHERE TicketID = :TicketID ORDER BY ID ASC");
      $DataBase->Bind(":TicketID", $TicketID);
      $DataBase->Execute();

      return $DataBase->ResultSet();
    }

    public function UpdateStatus($Status, $TicketID)
    {
      global $DataBase;

      $DataBase->Query("UPDATE Tickets SET Status = :Status WHERE ID = :TicketID");
      $DataBase->Bind(":Status", $Status);
      $DataBase->Bind(":TicketID", $TicketID);
      $DataBase->Execute();
    }

    public function SubmitAnswer($TicketID, $Content)
    {
      global $DataBase;

      $SubmitOK = '1';
      $Content = nl2br($Content);

      $Ticket = $this->SelectTicket($TicketID);

      if(count($Ticket['ID']) <> '1') {
        $SubmitOK = '0';
        $_SESSION['Error'] = 'Došlo je do greške prilikom slanja odgovora. Pokušajte ponovo!';
        header('location: support.php');
        exit();
      }

      if($Ticket['Status'] == '2') {
        $SubmitOK = '0';
        $_SESSION['Error'] = 'Ne možete odgovoriti na zatvoren tiket. Otvorite novi!';
        header('location: support.php');
        exit();
      }

      if(strlen($Content) < '50') {
        $SubmitOK = '0';
        $_SESSION['Error'] = 'Sadržaj mora biti duži od 50 karaktera!';
        header('location: viewticket.php?ID='.$TicketID);
        exit();
      }

      if($SubmitOK == '1') {
        $DataBase->Query("INSERT INTO TicketAnswers (TicketID, Title, Content) VALUES (:TicketID, :Title, :Content)");
        $DataBase->Bind(":TicketID", $TicketID);
        $DataBase->Bind(":Title",    "Odgovor Korisnika");
        $DataBase->Bind(":Content",  $Content);
        $DataBase->Execute();

        $this->UpdateStatus("0", $TicketID);

        $_SESSION['Success'] = 'Uspešno ste odgovorili na tiket.';
        header('location: viewticket.php?ID='.$TicketID);
        exit();
      } else {
          $_SESSION['Error'] = 'Došlo je do greške prilikom slanja odgovora. Pokušajte ponovo!';
          header('location: support.php');
          exit();
      }
    }

    public function CloseTicket($TicketID)
    {
      global $DataBase;

      $CloseOK = '1';

      $Ticket = $this->SelectTicket($TicketID);

      if($Ticket['Status'] == '2') {
        $CloseOK = '0';
        $_SESSION['Error'] = 'Nemoguće je zatvoriti već zatvoren tiket!';
        header('location: support.php');
        exit();
      }

      if($CloseOK == '1') {
        $this->UpdateStatus("2", $TicketID);

        $_SESSION['Error'] = 'Uspešno ste zatvorili tiket.';
        header('location: viewticket.php?ID='.$TicketID);
        exit();
      }
    }

  }

?>
