<?php
  include 'configs/sql.php';

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Users (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      Status VARCHAR(255) DEFAULT 'Active',
      FirstName VARCHAR(255) NOT NULL,
      LastName VARCHAR(255) NOT NULL,
      Username VARCHAR(255) NOT NULL,
      Password VARCHAR(255) NOT NULL,
      EmailAddress VARCHAR(255),
      PIN VARCHAR(255) NOT NULL,
      PIN_Hint VARCHAR(255) NOT NULL,
      City VARCHAR(255) NOT NULL,
      Country VARCHAR(255) NOT NULL,
      LastIP VARCHAR(255) NOT NULL,
      LastActivity VARCHAR(255) NOT NULL,
      RefPoints VARCHAR(255) DEFAULT '0',
      AdminNotes VARCHAR(32640) NOT NULL,
      RegisterDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Users created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS News (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      Title VARCHAR(255) NOT NULL,
      Content VARCHAR(32640) NOT NULL,
      PostDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table News created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Servers (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      UserID VARCHAR(255) NOT NULL,
      BoxID VARCHAR(255) NOT NULL,
      TemplateID VARCHAR(255) NOT NULL,
      Type VARCHAR(255) NOT NULL,
      Status VARCHAR(255) NOT NULL,
      Hostname VARCHAR(255) NOT NULL,
      ServerIP VARCHAR(255) NOT NULL,
      ServerPort VARCHAR(255) NOT NULL,
      SlotNumber VARCHAR(255) NOT NULL,
      Expires VARCHAR(255) NOT NULL,
      Username VARCHAR(255) NOT NULL,
      Password VARCHAR(255) NOT NULL,
      CreateDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Servers created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Boxes (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      BoxIP VARCHAR(255) NOT NULL,
      Username VARCHAR(255) NOT NULL,
      Password VARCHAR(255) NOT NULL,
      Location VARCHAR(255) NOT NULL,
      AddDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Boxes created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Templates (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      BoxID VARCHAR(255) NOT NULL,
      GameID VARCHAR(255) NOT NULL,
      TemplateName VARCHAR(255) NOT NULL,
      StartCommand VARCHAR(255) NOT NULL,
      FilesPath VARCHAR(255) NOT NULL,
      AddDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Templates created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Games (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      FullName VARCHAR(255) NOT NULL,
      QueryName VARCHAR(255) NOT NULL,
      QueryHostname VARCHAR(255) NOT NULL,
      QueryMaxplayers VARCHAR(255) NOT NULL,
      QueryNumplayers VARCHAR(255) NOT NULL,
      QueryMapname VARCHAR(255) NOT NULL,
      QueryGameMode VARCHAR(255) NOT NULL,
      AddDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Games created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS Tickets (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      UserID VARCHAR(255) NOT NULL,
      Status VARCHAR(255) NOT NULL,
      Title VARCHAR(255) NOT NULL,
      Content VARCHAR(32640) NOT NULL,
      ServerIP VARCHAR(255) NOT NULL,
      SubmitDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table Tickets created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }

  try {
    $SQL = "CREATE TABLE IF NOT EXISTS TicketAnswers (
      ID INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      TicketID VARCHAR(255) NOT NULL,
      Title VARCHAR(255) NOT NULL,
      Content VARCHAR(32640) NOT NULL,
      SubmitDate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    )";

    $CONN->exec($SQL);
    echo "Table TicketAnswers created successfully<br/>";
  } catch(PDOException $e) {
    echo $SQL . "<br>" . $e->getMessage();
  }
?>
