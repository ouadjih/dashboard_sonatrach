<?php
session_start();
include_once("default.php");
include_once("Login/functions/function.php");
$bdd=bdd();
if(getRole($_SESSION['user'],$bdd) != 'admin')
	{
		header('location:../db/indexe.php');
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
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Style.css">
    <link rel="stylesheet" type="text/css" href="Login/vendor/daterangepicker/daterangepicker.css">
</head>
<body>
	  	<?php

	
	  if(isset($_GET["id"]))
	  {
	    $id=htmlspecialchars(htmlentities($_GET["id"]));
	    $datas = getUserById($id, bdd());
	    
	  }
	?>
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		      <h1 class="h2">Modifier utilisateur :<?php echo $datas['user'];?> </h1>
		      		    </div>
		    
	 <div class="form-group col-xs-1  ">
	    <div class="col-xs-2  mt-3">
		    <label>Nom:</label>
		    <input type="text" id="nom"  value="<?php echo $datas['nom']; ?>" class="form-control">
		    <small  class="form-text text-muted">Modifier le nom</small>
	    </div>
	 	 <div class="col-xs-2  mt-3">
		    <label>Prenom:</label>
		    <input type="text" id="prenom"  value="<?php echo $datas['prenom']; ?>" class="form-control">
		    <small  class="form-text text-muted">Modifier le prenom  </small>
	    </div><div class="col-xs-2  mt-3">
		    <label>Num de tel:</label>
		    <input type="text" id="numTel"  value="<?php echo $datas['numTel']; ?>" class="form-control">
		    <small  class="form-text text-muted">Modifier le num de Tel  </small>
	    </div><div class="col-xs-2  mt-3">
		    <label>Adresse email:</label>
		    <input type="text" id="email"  value="<?php echo $datas['email']; ?>" class="form-control">
		    <small  class="form-text text-muted">Modifier l'email ! </small>
	    </div>
	    <div class="col-xs-2  mt-3">
							<select class="custom-select mb-3" name="role" id="role">
							  <option  disabled selected>Selectionne le Role</option>
							  <option >chef de Projet</option>
							  <option >manager</option>  
							</select>
	    </div>

	    <div class="col-xs-2 mt-3"  data-validate = "Password Confirmation is required">
		    <label>Nouveau mot de passe:</label>
		    <input type="text" id="pass"   class="form-control">
		    <small  class="form-text text-muted">Modifier le mot de passe  </small>
	    </div>

	   <button  style="float:right;" type="submit" name ="submit" onclick="modifier()" class="btn btn-primary">Modifier</button>
	</div>

</body>

<script>
  function modifier()//une fonction modifier pour modifier un article 
  {
    let id = <?php echo $_GET["id"];?>; //var de fct recoit la val id envoyer par la meth get dans la fct getnote
    let nom = $("#nom").val();//#var sont les vars recuperer par id des  les inputs 
    let prenom = $("#prenom").val();
    let numTel = $("#numTel").val();
    let email = $("#email").val();
    let role = $("#role").val();
    let pass = $("#pass").val();

    $.ajax( //fct ajax 
    {
      type:'post',//meth post 
      data:
      {
        id:id,
        nom:nom,
        prenom:prenom,
        numTel:numTel,
        email:email,
        role:role,
        pass:pass
      },
      url: 'modifU.php',//rediriger vers la page modif.php pour l'appel de fct ModifierArticle
      success:function(result)
      {
          Swal.fire( //framework pour afficher une alerte illustrer 
            'Utilisateur Modifié',//argument text1  
            'la modification a été effectuée avec succès',//argument big text
            'success'//type de resultat
          ).then(function(){//fonction pour rediriger la page vers la liste des  articles apres l'ajout avec succés
            
            location.href="ListeUsers.php";
          
          })
          
      }
    });
  }

</script>

</html>

