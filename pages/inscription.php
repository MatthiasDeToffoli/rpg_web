<?php


if($_POST[name] && $_POST[pass] && $_POST[pass2] && $_POST[mail]){
  testInscription($_POST[name],$_POST[pass],$_POST[pass2], $_POST[mail]);
}

function testInscription($Name,$Pass, $Pass2, $Mail){
  include("../utils/textformat.php");
  if(!charactersIsAllowed($Name) || strlen($Name) < 4) {
    echo errorText("Login contains not allowed characters or is to small");
    return;
  }

  if(!charactersIsAllowed($Pass) || strlen($Pass) < 4) {
    echo errorText("Password contains not allowed characters or is to small");
    return;
  }
  if($Pass != $Pass2){
    echo errorText("password repeat different than password");
    return;
  }
  $result = filter_var( $Mail, FILTER_VALIDATE_EMAIL );

  if(empty($result)){
    echo errorText("mail not valide");
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

  $req = "SELECT password FROM Player WHERE login = :login";
  $reqPre = $db->prepare($req);
  $reqPre->bindParam(':login', $Name);

  try {
    $reqPre->execute();
    $res = $reqPre->fetch();

    if (!empty($res)) {
      echo errorText("login already use");
      return;
    }
    else {
      addNewCompt($Name,hash("sha512", $Pass), $Mail,$db);
    }
  }
  catch (Exception $e) {
    echo $e->getMessage();
    exit;
  }


}

function addNewCompt($Name,$Pass, $Mail, $db){
  $req = "INSERT INTO Player(login, password, mail) VALUES (:login,:pass,:mail)";
  $reqPre = $db->prepare($req);
  $reqPre->bindParam(':login', $Name);
  $reqPre->bindParam(':pass', $Pass);
  $reqPre->bindParam(':mail', $Mail);

  try {
    $reqPre->execute();
    header('Location: https://rpgdetoma.com');
    exit();
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
<input name="name" type="text" maxlength = "12"/>
<h3>password : </h3>
<input name="pass" type="password" maxlength = "20"/>

<h3>repeat password : </h3>
<input name="pass2" type="password" maxlength = "20"/>

<h3>mail : </h3>
<input name="mail" type="mail" maxlength = "50"/>

<input type="submit" value="submit"/>


</form>
<?php  echo $loginError; ?>
</body>
</html>
