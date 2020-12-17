<?php
session_start();
 include_once("default.php");
include_once("Login/functions/function.php");
$bdd=bdd();
$role="admin";
if(getRole($_SESSION['user'],$bdd) != $role)
{
  echo"retourner a la page d'accueil <a href='indexe.php'>Accueil</a>";
  exit;
 // header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); 

}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="Style.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Liste des Utilisateurs:</h1>
      </div>
      <?php
        $reponse=$bdd->query('SELECT*FROM projet ORDER BY idp DESC LIMIT 0,10') or die(print_r($bdd->errorInfo()));
      ?>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID <i class="fa-pencil" title="Edit"></i></th>
      <th scope="col">Nom </th>
      <th scope="col">Prenom</th>
      <th scope="col">Num de Tel</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">User</th>
      <th scope="col">Modifier</th>
      <th scope="col">Supprimer</th>
    </tr>
  </thead>
  <tbody>
    <?php
      get_Users($_SESSION["user"],bdd()); 
    ?>
  </tbody>
</table>