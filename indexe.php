<?php 
session_start();
include_once("default.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home</title>
    <script type="text/javascript"src ="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src = "js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

  <?php
     
     include_once("Login/functions/function.php");
     $reponse=NULL;
  if(isset($_POST['search'])){
       $bdd=bdd();
        if(getRole($_SESSION['user'],$bdd) == "chef de Projet"){
          $reponse=$bdd->prepare('SELECT*FROM projet WHERE nomp=:nomp AND responsable=:responsable ');
          $reponse->execute(array('nomp'=>$_POST['search'],'responsable'=>$_SESSION['user'])) or die(print_r($bdd->errorInfo()));
        }
        if(getRole($_SESSION['user'],$bdd) == "manager") {
          $reponse=$bdd->prepare('SELECT*FROM projet WHERE nomp=:nomp ORDER BY idp ');
          $reponse->execute(array('nomp'=>$_POST['search'])) or die(print_r($bdd->errorInfo()));
        }
        if(getRole($_SESSION['user'],$bdd) == "admin") {
            $s=$_POST['search'];
            $resultat = $bdd->prepare("SELECT * FROM utilisateur where `nom` = '$s'");
            $resultat->execute();        
        }
      ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Résultats de recherche pour : <strong><?php echo $_POST['search']; ?></strong></h1>
</div>

<?php 
if(getRole($_SESSION['user'],$bdd) == "admin") {
if($donnees = $resultat->fetch())
{ echo $_SESSION['role'];
 ?>
 <table class='table table-hover'>
  <thead>
    <tr>

      <th scope='col'>ID <i class='fa-pencil' title='Edit'></i></th>
      <th scope='col'>Nom </th>
      <th scope='col'>Prenom</th>
      <th scope='col'>Num de Tel</th>
      <th scope='col'>Email</th>
      <th scope='col'>Role</th>
      <th scope='col'>User</th>
      <th scope='col'>Modifier</th>
      <th scope='col'>Supprimer</th>
    </tr>
    <?php
  $id=$donnees['id_user'];
        echo"
      <tr>
              <td>".$donnees['id_user']."</td>
              <td>".$donnees['nom']."</td>
              <td>".$donnees['prenom']."</td>
              <td>".$donnees['numTel']."</td>
              <td>".$donnees['email']."</td>
              <td>".$donnees['role']."</td>
              <td>".$donnees['user']."</td>
              <td>
                  <a style='color: orange;text-align: center' href='ModifierUser.php?id=$id' >
                    <svg width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
              </svg>
            </a>
              </td>
              <td> <a style='color: red;text-align: center' href='DeleteUser.php?id=$id' onclick='return confirm(\"Etes vous sure  de Supprimer?\");'>
                  <svg width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-person-dash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path fill-rule='evenodd' d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5-.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'/>
                           </svg>
                           </a>    
               </td> 
              
          </tr>";
}
else{
      echo '<h4>aucun résultat trouvé</h4>';
    }
}
if($donnees = $reponse->fetch()){ ?>
<table class="table table-hover ">
  <thead>
    <tr>
      <th scope="col">ID <i class="fa-pencil" title="Edit"></i></th>
      <th scope="col">Nom de Projet</th>
      <th scope="col">DECRIPTION</th>
      <th scope="col">Responsable</th>
      <th scope="col">Programme</th>
      <th scope="col">Programme</th>
      <th scope="col">Date Debut</th>
      <th scope="col">Date Fin</th>
  <?php if(getRole($_SESSION['user'],$bdd) == "chef de Projet"){?>
      <th scope="col">Modifier</th>
      <th scope="col">Supprimer</th>
    <?php }?>
    </tr>
    <tr>
            <td><?php echo '<strong>'.$donnees['idp'].'</strong>'?></td>
            <td><?php echo '<strong>'.$donnees['nomp'].'</strong>'?></td>
            <td><?php echo $donnees['description']?></td>
            <td><?php 
                $reponse2=$bdd->prepare('SELECT nom,prenom from utilisateur WHERE user=:user');
                $reponse2->execute(array('user'=>$donnees['responsable'])) or die(print_r($req->errorInfo()));
                $donnees2 = $reponse2->fetch();
                echo $donnees2['nom'].' '.$donnees2['prenom'];
                 ?>

           </td>
            <td><?php echo '<a href="resultatProjetF.php?idp='. $donnees['idp'] .'"><button class="btn btn-success btn-sm">Financier
            </button></a>';?></td>
            <td><?php echo '<a href="resultatProjetPh.php?idp='. $donnees['idp'] .'"><button class="btn btn-success btn-sm">Physique
            </button></a>';?></td>
            <td><?php echo $donnees['dateD']?></td>
            <td><?php echo $donnees['dateF']?></td>
            <?php if(getRole($_SESSION['user'],$bdd) == "chef de Projet"){?>
            <td>
                <form action="modifierProjetInfo.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $donnees['idp']; ?>"/>
                  <input type="submit" value="Modifier"/>
                </form>
            </td>
            <td>
              <button class="btn btn-danger btn-sm deletebtn" >Supprimer</button>
            </td>
            <?php }?>
          </tr>
  <?php
}
else{
      echo '<h4>aucun résultat trouvé</h4>';
    }
    $reponse->closeCursor();
}
  ?>
  </thead>
</table>

<?php get_note_card($_SESSION['user'],bdd());?>
<!-- Delete pop up form -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="deleteProjet.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="idp" value="<?php echo $donnees['idp']; ?>">
            <h4>voulez-vous supprimer ce projet ?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">annuler</button>
            <button type="submit" class="btn btn-primary">supprimer</button>
          </div>
        </form>
    </div>
  </div>
</div>
<!-- ///////////////////// -->
  <script>
  $(document).ready(function(){
    $('.deletebtn').on('click',function(){
      $('#deletemodal').modal('show');
    })
  })
  </script>
</main>
</body>

<script>
  $(document).ready(function(){
    $('.deletebtn').on('click',function(){
      $('#deletemodal').modal('show');
    })
  })
  </script>
</html>
