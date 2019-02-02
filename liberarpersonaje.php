<?php
if($_GET['act']=="do") {
  include("tmsdk.include.php");
  $_config['mysqli_host'] = '127.0.0.1';
  $_config['mysqli_port'] = 3306;
  $_config['mysql_user'] = "database";
  $_config['mysql_pass'] = "password";
  $_config['db_char'] = "characters";
  $_config['db_acct'] = "realmd";
  $cdb = new conndb($_config['mysqli_host'], $_config['mysqli_port'], $_config['mysqli_user'], $_config['mysqli_pass'], $_config['db_char']);
  $rdb = new conndb($_config['mysqli_host'], $_config['mysqli_port'], $_config['mysqli_user'], $_config['mysqli_pass'], $_config['db_acct']);
  $char = new char($cdb);
  $act = new account($rdb);
  $auth = $act->login($_POST['user'],$_POST['pass']);
  if($auth=="1") {
    $guid = $char->getGuid($_POST['char']);
    $aid = $act->getId($_POST['user']);
    $cid = $char->getAccountId($guid);
    $nivel = $char->getLevelMangos($guid);
    $clase = $char->getClass($guid);
    if($cid!=$aid) {
	  echo "Los datos de la cuenta no coinciden.";
      die("Los datos de la cuenta no coinciden.");
    }
    $status = $char->getOnlineStatus($guid);
    if(!$status) {
      $home = $char->getHome($guid);
    if($clase != 6 || ($clase == 6 && $nivel >61)) {
      $char->setLocation($guid,$home['posX'],$home['posY'],$home['posZ'],$home['mapId']);
    }
      $char->revive($guid);
      echo("<p style=\"color:#555555;font-family:Tahoma;font-size:13\">Personaje Liberado</p>");
    } else {
        echo("<p style=\"color:#555555;font-family:Tahoma;font-size:13\">El personaje aun esta conectado. Desconectate o espera unos minutos.</p>");
      }
  } else {
      echo("<p style=\"color:#555555;font-family:Tahoma;font-size:13\">Los datos de la cuenta no coinciden. Revisa Usuario, Password y Nombre de Personaje</p>");
    }
}

?>
