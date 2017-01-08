<?php


if($_POST[name] && $_POST[pass] && $_POST[pass2] && $_POST[mail]){
  testInscription($_POST[name],$_POST[pass],$_POST[pass2], $_POST[mail]);
}

function testInscription($Name,$Pass, $Pass2, $Mail){
include("../utils/textformat.php");
  if(!charactersIsAllowed($Name)) {
     echo errorText("Login contains not allowed characters");
     return;
  }

  if(!charactersIsAllowed($Pass)) {
     echo errorText("Password contains not allowed characters");
     return;
  }
if($Pass != $Pass2){
   echo errorText("password repeat different than password");
   return;
}
  //contain also the host domain, data base name, user and password
  include("../database/info.php");

  try {
    $db = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $password);
    //$db = new PDO("mysql:host=localhost;dbname=rpg_web", "root", "mysql");
  }
  catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }



}

function charactersIsAllowed($string){
  preg_match('/^[-a-zA-Z0-9 .]+$/',$string, $match);

  if(empty($match)) {
    return false;
  }
  return true;
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <title>RPG </title>
  <CENTER><h1>Inscription</h1></CENTER>
</head>

<body>

  <form action="" method="post">
  </br>
</br>
<h3>Login : </h3>
<input name="name" type="text" maxlength = "8"/>
<h3>password : </h3>
<input name="pass" type="password" maxlength = "8"/>

<h3>repeat password : </h3>
<input name="pass2" type="password" maxlength = "8"/>

<h3>mail : </h3>
<input name="mail" type="mail" maxlength = "50"/>

<input type="submit" value="submit"/>


</form>
<?php  echo $loginError; ?>
</body>
</html>
