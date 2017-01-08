<?php
include("database/info.php");

if($_POST[name] && $_POST[mdp]){
  try {
    $db = new PDO("mysql:host=".$host.";dbname=".$name, $user, $password);
  }
  catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }


  $req = "SELECT password FROM Player WHERE login = :login";
  $reqPre = $db->prepare($req);
  $reqPre->bindParam(':login', $_POST[name]);

  try {
    $reqPre->execute();
    $res = $reqPre->fetch();

    // if player is in db -> return profil info
    if (!empty($res)) {
      if($res[0] == $_POST[mdp]) die("login");
      else {
         die("wrong mdp");
      }
    }
    else {
      die("wrong login");
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

  <form action="index.php" method="post">

  </br>
</br>
<h3>Login : </h3>
<input name="name" type="text" maxlength = "8"/>
<h3>mdp : </h3>
<input name="mdp" type="password" maxlength = "8"/>



<input type="submit" value="submit"/>

</form>
</body>
</html>
