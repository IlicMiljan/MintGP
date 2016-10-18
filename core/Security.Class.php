<?php
  if(count(get_included_files()) == 1) exit("Direct access not permitted.");

  class Security {
    public function InputString($String)  {
      return htmlspecialchars(trim($String));
    }

    public function Hash($Password) {
      return password_hash($Password, PASSWORD_DEFAULT);
    }

    public function VerifyHash($Password, $PassowrdCheck) {
      if(password_verify($Password, $PassowrdCheck)) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
  }

?>
