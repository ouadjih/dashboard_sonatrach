<?php
session_start();
include_once("default.php");
include_once("Login/functions/function.php");
$bdd=bdd();
$role = "chef de Projet";
if(getRole($_SESSION['user'],$bdd) != $role)
{
  exit;
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Style.css">
</head>
<body>
   <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
 
<?php
 include_once("default.php");
  
  if(!isset($_POST['NomP']) || !isset($_POST['DescriptionP']) || !isset($_POST['dateD']) || !isset($_POST['dateF'])){

?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Ajouter un nouveau projet : </h1>
        </div>
    <form action="AddProjetInfo.php" method="post">
      <?php
        if(isset($_GET['mess'])){

          echo '<h6 style="color:red;">'.strip_tags($_GET['mess']).'</h6>';
        }
      ?>
          <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Nom de Projet</span>
          </div>
          <input type="text" class="form-control" placeholder="Nom Projet" name="NomP" aria-describedby="basic-addon1" required/>

          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Description de Projet</span>
          </div>
          <input type="text" class="form-control" placeholder="Description de Projet" name="DescriptionP" aria-describedby="basic-addon1" required/>
         </div>
         <?php
           if(isset($_GET['mess2'])){
             echo '<h6 style="color:red;">'.strip_tags($_GET['mess2']).'</h6>';
           }
         ?>
          <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1" >Date Debut</span>
            <input type="date" class="form-control" placeholder="dateD" name="dateD"  aria-describedby="basic-addon1" required/>

            <span class="input-group-text" id="basic-addon1">Date Fin</span>
            <input type="date" class="form-control" placeholder="DateF" name="dateF" aria-describedby="basic-addon1" required/>

          </div>
         <button type="submit" class="btn btn-secondary btn-lg" >Suivant</button>
      </form>
   
<?php }
    else{

      $req=$bdd->prepare('SELECT nomp FROM projet WHERE nomp=:nomp');
      $req->execute(array('nomp'=>$_POST['NomP'])) or die(print_r($req->errorInfo()));
      if($req->fetch()){
        $req->closeCursor();
        echo"req executed"; ?>
        <script> location.replace("AddProjetInfo.php?mess=nom déjà pris"); </script>
<?php
      }
      if($_POST['dateF'] < $_POST['dateD']){?>
        <script> location.replace("AddProjetInfo.php?mess2=Date Fin doit être supérieur à la Date Debut"); </script>
<?php
      }
 else{  
          
          $req->closeCursor();
          $_POST['NomP'] = htmlentities(trim($_POST['NomP']) ,ENT_QUOTES);
          $_POST['DescriptionP'] = htmlentities(trim($_POST['DescriptionP']), ENT_QUOTES);

          $query ="INSERT INTO `projet`(`nomp`, `description`, `responsable` ,`dateD`, `dateF`) VALUES ('".$_POST['NomP']."','".$_POST['DescriptionP']."','".$_SESSION['user']."','".$_POST['dateD']."','".$_POST['dateF']."')";
          $res= $bdd->exec($query) or die('Erreur SQL !<br>'.$query.'<br>'.$bdd->errorInfo());
         
          $req3=$bdd->prepare('SELECT idp FROM projet WHERE nomp=:nomp');
          $req3->execute(array('nomp'=>$_POST['NomP'])) or die(print_r($req->errorInfo()));
          $result=$req3->fetch();
          $req3->closeCursor();
          $phpvar=$result['idp'];
          ?>
          <script>
              var variable="<?php echo $phpvar;?>";
              variable=parseInt(variable);
             location.replace("AddProjet.php?idp="+variable+"");
          </script>
<?php
      }
    }
?>


   </main>
</body>
 
            
            </script>
</html>
