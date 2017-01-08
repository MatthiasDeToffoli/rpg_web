<?php


if($_POST[name] && $_POST[pass]){
  testConnection($_POST[name],$_POST[pass]);
}

function testConnection($Name,$Pass){

  //contain also the host domain, data base name, user and password
  include("database/info.php");
  include("utils/textformat.php");

  try {
    $db = new PDO("mysql:host=".$host.";dbname=".$dbname, $user, $password);
    //$db = new PDO("mysql:host=localhost;dbname=rpg_web", "root", "mysql");
  }
  catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }


  $req = "SELECT password FROM Player WHERE login = :login";
  $reqPre = $db->prepare($req);
  $reqPre->bindParam(':login', $Name);

  try {
    $reqPre->execute();
    $res = $reqPre->fetch();

    if (!empty($res)) {
      if($res[0] == $Pass) die("login");
      else {
         echo errorText("wrong password");
      }
    }
    else {
      echo errorText("wrong login");
    }
  } catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <title>RPG </title>
  <CENTER><h1>Conexion</h1></CENTER>
</head>

<body>

  <form action="" method="post">
  </br>
</br>
<h3>Login : </h3>
<input name="name" type="text" maxlength = "8"/>
<h3>password : </h3>
<input name="pass" type="password" maxlength = "8"/>



<input type="submit" value="submit"/>


</form>

<a href="./pages/inscription.php">sign in</a>
</body>
</html>
