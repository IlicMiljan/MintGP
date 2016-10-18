
<?php
  require_once "libs/Smarty.class.php";

  $Smarty = new Smarty();

  $Smarty->setTemplateDir("templates/");
  $Smarty->setCompileDir("templates_c/");
  $Smarty->setConfigDir("configs/");
  $Smarty->setCacheDir("cache/");

  /* Development Only */
  $Smarty->force_compile = TRUE;
?>
